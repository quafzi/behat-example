This is a small example project to show how to develop behaviour driven, using Behat_, and unit test driven, using PHPUnit.

.. _Behat: http://behat.org/

In most cases, you'll get a feature description of some piece of software you should develop. If you follow the following steps, you could transform this plaintext description into a real application more easily. First of all, you need to write feature descriptions in Gherkin_ syntax (using your mother tongue):

Behaviour Driven Development
============================

Prepare your project for Behat
------------------------------

Create a `composer.json` with this content:

::

    {
        "require-dev": {
            "behat/behat": "2.4.*@stable"
        },

        "config": {
            "bin-dir": "bin/"
        }
    }

Load Composer and install your dependencies:

::

    curl http://getcomposer.org/installer | php
    php composer.phar install --prefer-source --dev

Initialize Behat:

::

    bin/behat --init

Usage
-----

Write down your use cases (in Gherkin_ syntax):

.. _Gherkin: http://docs.behat.org/guides/1.gherkin.html

::

    vim features/your_first.feature

Run behat tests:

::

    bin/behat

You may want your test class to be filled up with new use cases:

::

    bin/behat --append-snippets

Wake up your tests:

::

    vim tests/BehatContext.php

Now it's time to start writing your code:

Test Driven Development
=======================

Prepare your project
--------------------

Installing PHPUnit globally is a bad idea, because your tests could fail, if you update your PHPUnit.

Extend your `composer.json` to install phpunit. Additionally, you could also use Mockery to create mock objects, if you like to.

::

    {
        "require-dev": {
            "behat/behat": "2.4.*@stable",
            "mockery/mockery": "dev-master@dev",
            "phpunit/phpunit": "3.7.*"
        },

        "config": {
            "bin-dir": "bin/"
        }
    }

Update your dependencies:

::

    php composer.phar update --prefer-source --dev

For better usability, I recommend to create a phpunit.xml(.dist) to define some testing settings for your application.

If you now run phpunit, it will complain about missing tests:

::

    bin/phpunit

Write tests and code
--------------------

Now, it's time to start developing. You have to create an application architecture, including some main classes. For every class you should create a test class extending PHPUnit_Framework_TestCase. Now you are ready to write your first test method: Write assertions about your methods you plan to implement - and don't forget about assertions of what you do *not* expect. If there are external dependencies, just mock them.

Btw.: It is always a good idea to read `PHPUnit documentation`_.

.. _`PHPUnit documentation`: http://www.phpunit.de/manual/current/en/index.html

When you're done with your first test, you should make sure, that your tests fail, since your methods are not implemented, yet. After that, you can start to implement the method until your test passes. You'll probably feel the need to write other methods - so start again writing a test!

From time to time, you should make sure that your tests cover your application (100% coverage would be great, but keep in mind: perfection is the biggest enemy of greatness!):

::

    bin/phpunit --coverage-html=coverage/

This will create a browsable coverage report in folder "coverage". Please note, that this is line coverage, not path coverage!

Time to refactor
----------------

After your test passes, you need to have a look at your code. Is it complex? Is it clear? Could every other developer easily understand what your code does? Did you find any existing code doing similar things? Don't hesitate: refactor immediately and run your whole test suite to make sure that everything still works after refactoring.

Ready? Go!
==========

During development, you will have to run your unit tests again and again. They help you to create good, maintainable code and to find bugs before your project leader or your customer does. Of course, there may remain some bugs. In that case, you should write a test for this bug: This test will be written to verify the bug, to help you fixing it, and to keep the bug away permanently.

When your unit tests are green, it's time to run Behat_ again. They will show you, if all requirements were met:

::

    bin/behat

If that's the case, you're done: Send its result to your customer and release!
