<?php

namespace Acme\DemoBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
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
}
