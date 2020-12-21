<?php

namespace App\Blog\Infrastructure\Symfony\Console;

use App\Blog\Domain\Content;
use App\Blog\Domain\Title;
use App\Shared\Infrastructure\CommandBus;
use App\Shared\Infrastructure\File;
use Assert\Assert;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreatePostCommand extends Command
{
    protected static $defaultName = 'blog:create-post';

    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('blog:create-post')
            ->setDescription('Creates a new blog post.')
            ->setHelp('This command allows you to create a post.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $question = $this->getHelper('question');

        $title = $question->ask($input, $output, new Question('Set title: '));
        $content = $question->ask($input, $output, new Question('Set Content: '));
        $image = $question->ask($input, $output, new Question('Send image path: '));

        try {
            Assert::that($title)->string(20);
            Assert::that($title)->maxLength(20);
            Assert::that($content)->string();
            Assert::that($content)->minLength(20);
            Assert::that($image)->url();
        } catch (\Exception $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');

            return 0;
        }

        $this->commandBus->handle(
            new \App\Blog\Application\CreatePostCommand(
                $title,
                $content,
                File::createFromUrl($image)
            )
        );

        $output->writeln('<info>Post has been created</info>');

        return 1;
    }

}