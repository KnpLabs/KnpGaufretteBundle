<?php

namespace Knp\Bundle\GaufretteBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Gaufrette\FilesystemMapInterface;
use Gaufrette\Glob;

/**
 * Command that lists the file keys of a filesystem
 *
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class FilesystemKeysCommand extends Command
{
    /**
     * @var FilesystemMapInterface
     */
    private $filesystemMap;

    public function __construct(FilesystemMapInterface $filesystemMap)
    {
        $this->filesystemMap = $filesystemMap;

        parent::__construct();
    }
    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('gaufrette:filesystem:keys')
            ->setDescription('List all the file keys of a filesystem')
            ->addArgument('filesystem', InputArgument::REQUIRED, 'The filesystem to use')
            ->addArgument('glob', InputArgument::OPTIONAL, 'An optional glob pattern')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command lists all the file keys of the specified filesystem:

    <info>php %command.full_name% my_filesystem</info>

You can also optionaly specify a glob pattern to filter the results:

    <info>php %command.full_name% my_filesystem media_*</info>
EOT
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filesystemName = $input->getArgument('filesystem');
        $glob = $input->getArgument('glob');

        if (!$this->filesystemMap->has($filesystemName)) {
            throw new \RuntimeException(sprintf('There is no \'%s\' filesystem defined.', $filesystemName));
        }

        $filesystem = $this->filesystemMap->get($filesystemName);
        $keys       = $filesystem->keys();

        if (!empty($glob)) {
            $glob = new Glob($glob);
            $keys = $glob->filter($keys);
        }

        $count = count($keys);

        $message = $count ? sprintf(
                'Bellow %s the <info>%s key%s</info> that were found:',
                $count > 1 ? 'are' : 'is',
                $count,
                $count > 1 ? 's': ''
            ) : "<info>0 keys</info> were found.";

        $output->writeln($message);

        $output->setDecorated(true);
        foreach ($keys as $key) {
            $output->writeln(' - <info>' . $key . '</info>');
        }

        return 0;
    }
}
