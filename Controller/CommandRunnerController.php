<?php

namespace Mrafalko\CommandRunnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CommandRunnerController extends Controller
{
    /**
     * @Route("/command-runner/{commandName}")
     * @Template()
     *
     * @param $commandName
     * @param Request $request
     * @return array
     */
    public function indexAction($commandName, Request $request)
    {
        $kernel = $this->container->get('kernel');
        $app = new Application($kernel);

        $params = $request->get('params');

        if (!is_array($params)) {
            // Bad params
            $params = array();
        }

        $options = $request->get('options');

        if (!is_array($options)) {
            // Bad options
            $options = array();
        }

        $preparedOptions = array();
        foreach ($options as $option => $value) {
            $preparedOptions['--' . $option] = $value;
        }

        $string = $commandName;

        foreach ($params as $param) {
            $string .= ' ' . $param;
        }

        foreach ($preparedOptions as $key => $option) {
            if (empty($value)) {
                $string .= ' ' . $key;
            } else {
                $string .= ' ' . sprintf('%s=%s', $key, $option);
            }
        }

        $input = new StringInput($string);
        $output = new StreamOutput(fopen('php://temp', 'w'));

        // Run the command
        $app->doRun($input, $output);

        rewind($output->getStream());
        $response = stream_get_contents($output->getStream());

        return array('response' => $response);
    }
}

