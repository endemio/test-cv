<?php

namespace App;

require_once './vendor/autoload.php';

use App\Builders\RuleBuilder;
use App\Builders\EmployerBuilder;
use App\Builders\OptionBuilder;
use App\Entity\Recount;
use App\Entity\Tax;

// Set employers
try {
    $employer1 = (new EmployerBuilder('Alice', 28, 6000))->addKids(2)->build();
    $employer2 = (new EmployerBuilder('Bob', 52, 4000))->addCar()->addKids(3)->build();
    $employer3 = (new EmployerBuilder('Charlie', 36, 5000))->addKids(3)->addCar()->build();
} catch (\TypeError $exception){
    die($exception->getMessage());
} catch (\InvalidArgumentException $exception){
    die($exception->getMessage());
}

// Set country tax
$tax = new Tax(20);

$options = (new OptionBuilder())
    ->addRule((new RuleBuilder())->ageGreater(55)->increase()->salary()->percent(10)->build())
    ->addRule((new RuleBuilder())->ageGreater(50)->increase()->salary()->percent(7)->build())
    #->addRule((new RuleBuilder())->ageGreater(50)->increase()->salary()->percent(7)->build())
    #->addRule((new RuleBuilder())->ageGreater(48)->increase()->salary()->percent(7)->build())
    #->addRule((new RuleBuilder())->ageLower(30)->increase()->salary()->money(100)->build())
    #->addRule((new RuleBuilder())->ageLower(28)->increase()->salary()->money(200)->build())
    ->addRule((new RuleBuilder())->kidsGreater(2)->decrease()->tax()->percent(2)->build())
    #->addRule((new RuleBuilder())->kidsGreater(2)->decrease()->tax()->percent(1)->build())
    #->addRule((new RuleBuilder())->kidsGreater(5)->decrease()->tax()->percent(7)->build())
    ->addRule((new RuleBuilder())->carByCompany()->decrease()->salary()->money(700)->build())
    ->addRule((new RuleBuilder())->carByCompany()->decrease()->salary()->money(500)->build())
    ->checkAge()
    ->checkKids()
    ->checkCar()
    ->build();

$change1 = (new Recount($employer1, $tax, $options))->getSummary();
$change2 = (new Recount($employer2, $tax, $options))->getSummary();
$change3 = (new Recount($employer3, $tax, $options))->getSummary();

