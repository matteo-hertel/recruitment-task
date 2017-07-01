## Task Execution

### Intro
The task per se it's quite easy, one of the requirement was to show OOP and testing skills
 so the code is quite over-engineered, as a rule of thumb you should never write over-engineered code
  but for a tech test should be ok
  
  In order to use the scrip one of the following needs to be issue first
  
  ```php
  composer install
```

or

```php
./test.sh
```

  
### Usage

There are two scripts avaialable:

- custom made cli script
- command based on the Symfony console

The reason of having two is simple, the symfony command, it's obviously more robust but 
 doesn't fit 100% the requirement of having the command runnable like this
 
 ```php 
php script.php data/file.yml
or
php script.php --input="data/file.xml" --output="results/result.txt"
```
because attention to detail is important I'll provide both the more robust solution and 
a solution that fits 100% the requirement

#### custom made cli script usage

```php
php script.php data/file.yml
php script.php --input="data/file.xml" --output="results/result.txt"
```

#### command based on the Symfony console usage

```php
./console.php script data/file.yml
./console.php script --input="data/file.xml" --output="results/result.txt"
./console.php script --output="results/result.txt" --input="data/file.yml"
./console.php script --output="results/result.txt" data/file.csv

```
  
### Execution

The task went through different steps:

1. Analysis
2. Planning
3. Coding and Testing
4. Review


#### Analysis
The requirement were clearly written in a short document, so not much happened here but in
a real life scenario this is one of the most important step to ensure the end product quality

#### Planning
Again the task was quite short so most of the planning was "How do I follow SOLID for this task"?
In particular Single Responsibility Principle  and Interface Segregation, so all the interfaces have been defined
and the high level API of the different classes implementing the interfaces, the last part was to
ensure extensibility, in particular: What if we want to support a new file type?

#### Coding and Testing

There is a mixture of TDD and simple unit testing, TDD for the single classes, unit and Feature testing
for most of the misc logic and console command.

One key aspect of the app is the way a parser is chosen, the general gist is: Based on the
file extension, we peek in the defined namespace to see if there is a {ext}Parser class
defined, if there is use that class as parser, all the parsers must implement the same interface
this ensures consistent API that leads to have a good extensibility because parsers don't need to
be explicitly defined or imported, they need to be there and they will be automatically picked up

Same approach was used for testing the parsers, because they need ti behave the same, the test
will load all the Parses from the defined classes in the namespace and will test them with the very same way
it's a different approach to testing those classes

#### Review

Once the code was done and the test were green I checked back the requirement and I noticed
that my output wasn't firring 100% the requirements, so I went back and I've added a solution
that was less robust that using component working out of the box but fitting the requirement 100%
the very last step was to add this documentation for reference