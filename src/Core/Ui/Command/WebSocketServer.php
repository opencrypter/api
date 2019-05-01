<?php
declare(strict_types=1);

namespace Core\Ui\Command;

use Core\Ui\Ws\Controller;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebSocketServer extends Command
{
    /**
     * @var Controller
     */
    private $controller;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('opencrypter:websocket:start')
            ->setDescription('Starts the websocket server')
            ->addArgument('port', InputArgument::REQUIRED, 'server port');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $websocket = new Server(
            'tcp://127.0.0.1:' . $input->getArgument('port'),
            $this->controller->client()->getEventLoop()
        );

        $server = new IoServer(
            new HttpServer(
                new WsServer($this->controller)
            ),
            $websocket,
            $this->controller->client()->getEventLoop()
        );


        $server->loop->run();
    }
}
