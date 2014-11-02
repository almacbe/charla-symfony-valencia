<?php

namespace Acme\DemoBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Gherkin\Node\TableNode;

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareContext
{
    private $kernel;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct()
    {
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^the database is clean$/
     */
    public function theDatabaseIsClean()
    {
        $em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
        $em->createQuery('DELETE AcmeDemoBundle:User')->execute();
        $em->flush();
    }

    /**
     * @Given /^there are users:$/
     */
    public function thereAreUsers(TableNode $table)
    {
        $userManager = $this->kernel->getContainer()->get('fos_user.user_manager');
        foreach ($table->getHash() as $hash) {
            $user = $userManager->createUser();
            $user->setUsername($hash['username']);
            $user->setPlainPassword($hash['password']);
            $user->setEmail($hash['email']);
            $user->setEnabled(true);
            $userManager->updateUser($user);
        }
    }

    /**
     * @Given /^I wait (\d+) miliseconds$/
     */
    public function iWaitMiliseconds($arg1)
    {
        $minkSession = $this->getSession();
        $minkSession->wait($arg1);
    }
}
