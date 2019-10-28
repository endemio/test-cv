## Test example

### Task
```
Please, keep in mind OOP, software design patterns, code architecture, tests and accuracy
in implementation during developing.

Here you need to build an application which can calculate the salary of employees.

We need to have an expandable system of bonuses or deductions.

Explanation
- Country Tax for salaries is 20%
- If an employee older than 50 we want to add 6% to his salary
- If an employee has more than 2 kids we want to decrease his Tax by 3%
- If an employee wants to use a company car we need to deduct $450

Situation
- Ann is 24 years old, she has 2 kids and her salary is $5500
- Robert is 55, he is using a company car and his salary is $4300
- Margaret is 36, he has 3 kids, company car and his salary is 5400
```


### Application structure
```
- example_1
    |
    |- src
    |   |
    |   |- Builders
    |   |- Counters
    |   |- Entity
    |   |- Interfaces
    |   
    |- tests
    |- vendors
    |- docker
    |- docker-compose.yml
    |- start.php
    |- composer.json
    |- README.md
```

### Start application
1. Clone application 
```
    git clone https://github.com/endemio/test-cv

```
2. Install docker/docker-compose (this is example for Centos 7)
```

yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
yum install -y docker-ce
sudo groupadd docker
sudo usermod -aG docker $USER
sudo systemctl enable docker.service
sudo systemctl start docker.service
reboot
```
**Important**: do not forget replace *$USER* to you username in OS 

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.24.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
```

3. Build application
```
cd ./example_1
docker-compose up -d

```

### Application settings

1. Create employers. Each employer has *name*, *age* and *salary*.
   ```php
    $employerBuilder = new EmployerBuilder('Alice', 28, 6000)
   ```
   but also he/she can have kid/kids and use company car
   ```php
   $employerBuilder->addKids(2); # 2 is number of kids
   $employerBuilder->addCar(); # it's mean that employer using company car
   ```
   When you set all option for employer - "build" him/her;
   ```php
   $employer = $employerBuilder->build();
   ```
  
2. Set country tax
    ```php
    $tax = new Tax(20); # Tax value in percent
    ```

3. Set bonus and deduction rules.

    First of all create rule builder.
    ```php
    $ruleBuilder = new RuleBuilder();
    ```
    then select one of parameters which we will use to decide - are we going to pay bonus or make deduction
    ```php
    $ruleBuilder->ageGreater(55); # If employer age greater 55
    $ruleBuilder->kidsGreater(2); # If employer has more then 2 kids (3,4,...)
    $ruleBuilder->carByCompany(); # If employer use company car
    ```
    and add actions in this case
    ```php
    $ruleBuilder->increase();
    $ruleBuilder->decrease();
    ```
    for next options
    ```php
    $ruleBuilder->salary(); # Employer salary (money)
    $ruleBuilder->tax(); # Employer paymnent for country tax (money)
    ```
    change by next options
    ```php
    $ruleBuilder->percent(10); # Change value for 10% for salary or 10% percent points for tax
    $ruleBuilder->money(500); # Change for $500, but not more then entire country tax paymnet 
    ```
    after all just "build"
    ```php
    $rule = $ruleBuilder->build();
    ```
    
    **Important**: You can set all option in random order, but *RuleBuilder()* choose first mention as main. For example:
    
    ```php
    $ruleBuilder->increase()->decrease();
    ```
    will be stored as "increase"

    **Important**: Application allow set multiple rules for each "type" (ageGreater, ageLower, kidsGreater and etc) but will use only **last** rule you set with the same parameter (age/kids).

    **Important**: Application use rule with nearest parameter value to employer settings. For example, if you set *ageGreater(50), ageGreater(53), ageGreater(56)*, for employer with age 54 application choose rule with *ageGreater(53)*, not *ageGreater(50)* even if bonus for *ageGreater(50)* will be greater then for *ageGreater(53)*  

4. Set check options

    Create option builder
    ```php
    $optionsBuilder = new OptionBuilder();
    ```
    add checks you are going to use
    ```php
    $optionsBuilder->checkAge(); # Check rules with age
    $optionsBuilder->checkKids(); # Check rules with kids
    $optionsBuilder->checkCar(); # Check rules with company car
    ```
    and add rules you want to use for that (which you have created above in p.3)
    ```php
    $optionsBuilder->addRule($rule1);
    $optionsBuilder->addRule($rule2);
    .
    .
    .
    $optionsBuilder->addRule($ruleN);
    ```
    and build at the end
    ```php
    $options = $optionsBuilder->build()
    ```

5. Count salary payment changes for each employer
    ```php
    $change = (new Recount($employer, $tax, $options))->getSummary();
    ```
    If *$change*>0 - company will increase payment (make bonus payment), if  *$change*<0 - company will decrease payment (make deduction).
    
    If you start this script in console you will see table with log with bonuses/deductions for each rule
    ```txt
    Start bonus is 0 for Alice
    +--------------------+----------+
    |     Rule type      |  Value   |
    +--------------------+----------+
    |         age_greater|         0|
    | kids_number_greater|       100|
    |         car_company|      -500|
    +--------------------+----------+
    |      Summary       |      -400|
    +--------------------+----------+
    ```

### Application test
Enter into container and start tests
```
docker-compose exec app bash
composer install
./vendor/bin/phpunit ./tests/.
exit
```

### Application start
Enter into container and start script
```
docker-compose exec app bash
php start.php
exit
```














































