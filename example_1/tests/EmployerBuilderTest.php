<?php


namespace App\Tests;


use App\Builders\EmployerBuilder;
use App\Entity\Employer;

use TypeError;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class Ru extends TestCase
{

    public function testBuildEmployerInstance(){

        $employerBuilder = new EmployerBuilder('test',50,1000);

        $employer = $employerBuilder->build();

        $this->assertInstanceOf(Employer::class,$employer);

    }

    public function testBuildEmployerInsertDataException(){

        $this->expectException(TypeError::class);

        new EmployerBuilder('test','sss',1000);

        $this->expectException(InvalidArgumentException::class);

        new EmployerBuilder('test',-100,1000);

        $this->expectException(InvalidArgumentException::class);

        new EmployerBuilder('test',100,-1000);

    }

    public function testBuildEmployerValues(){

        $employerBuilder = new EmployerBuilder('test',50,1000);

        $this->assertSame('test',$employerBuilder->getName());
        $this->assertSame(50.0,$employerBuilder->getAge());
        $this->assertSame(1000.0,$employerBuilder->getSalary());

        $this->assertEquals('test',$employerBuilder->getName());
        $this->assertEquals(50,$employerBuilder->getAge());
        $this->assertEquals(1000,$employerBuilder->getSalary());

        $employerBuilder = new EmployerBuilder(12,'50','1000');

        $this->assertSame('12',$employerBuilder->getName());
        $this->assertSame(50.0,$employerBuilder->getAge());
        $this->assertSame(1000.0,$employerBuilder->getSalary());

        $this->assertEquals('12',$employerBuilder->getName());
        $this->assertEquals(50,$employerBuilder->getAge());
        $this->assertEquals(1000,$employerBuilder->getSalary());

    }


}