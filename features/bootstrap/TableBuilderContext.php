<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Faker\Factory;
use Root\App\Customer;

/**
 * Defines application features from the specific context.
 */
class TableBuilderContext implements Context
{

    /**
     * @var Customer[]
     */
    private array $customers = [];

    /**
     * @var Customer[]
     */
    private array $matchingCustomers = [];

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given /^that customer file contains:$/
     */
    public function thatCustomerFileContains(TableNode $table)
    {
        foreach ($table as $row) {
            $this->customers[] = (new CustomerBuilder(Factory::create()))->withInfo($row);
        }
    }

    /**
     * @When /^I search for a customer named "([^"]*)"$/
     */
    public function iSearchForACustomerNamed(string $customerName)
    {
        foreach ($this->customers as $customer) {
            if ($customer->firstname === $customerName || $customer->lastname === $customerName) {
                $this->matchingCustomers[] = $customer;
            }
        }
    }

    /**
     * @Then /^I should get (\d+) result$/
     */
    public function iShouldGetResult(int $expectedNumberOfCustomers)
    {
        $actualNumberOfFoundCustomer = count($this->matchingCustomers);
        if($actualNumberOfFoundCustomer !== $expectedNumberOfCustomers) {
            throw new Exception(sprintf("Didn't get the expected number of customer through search. Expected %d and got %s", $expectedNumberOfCustomers, $actualNumberOfFoundCustomer));
        }
    }
}
