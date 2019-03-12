<?php

namespace Knp\Bundle\GaufretteBundle\Command;

use Gaufrette\Glob;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Command that lists the file keys of a filesystem.
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class FilesystemKeysCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('gaufrette:filesystem:keys')
            ->setDescription('List all the file keys of a filesystem')
            ->addArgument('filesystem', InputArgument::REQUIRED, 'The filesystem to use')
            ->addArgument('glob', InputArgument::OPTIONAL, 'An optional glob pattern')
            ->setHelp(<<<EOT
The <info>gaufrette:filesystem:list</info> command lists all the file keys of the specified filesystem:

    <info>./app/console gaufrette:filesystem:list my_filesystem</info>

You can also optionaly specify a glob pattern to filter the results:

    <info>./app/console gaufrette:filesystem:list my_filesystem media_*</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filesystem = $input->getArgument('filesystem');
        $glob = $input->getArgument('glob');
        $container = $this->getContainer();
        $serviceId = \sprintf('gaufrette.%s_filesystem', $filesystem);

        if (!$container->has($serviceId)) {
            throw new \RuntimeException(\sprintf('There is no \'%s\' filesystem defined.', $filesystem));
        }

        $filesystem = $container->get($serviceId);
        $keys = $filesystem->keys();

        if (!empty($glob)) {
            $glob = new Glob($glob);
            $keys = $glob->filter($keys);
        }

        $count = \count($keys);

        $message = $count ? \sprintf(
                'Bellow %s the <info>%s key%s</info> that were found:',
                $count > 1 ? 'are' : 'is',
                $count,
                $count > 1 ? 's' : ''
            ) : '<info>0 keys</info> were found.';

        $output->writeln($message);

        $output->setDecorated(true);
        foreach ($keys as $key) {
            $output->writeln(' - <info>'.$key.'</info>');
        }
    }
}
