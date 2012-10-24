This is a small example project to show how to develop behaviour driven, using Behat_.

.. _Behat: http://behat.org/

First steps in Behaviour Driven Development
===========================================

Create a `composer.json` with this content:

::

    {
        "require": {
            "behat/behat": "2.4.*@stable"
        },

        "config": {
            "bin-dir": "bin/"
        }
    }

Install Behat:

::

    curl http://getcomposer.org/installer | php
    php composer.phar install --prefer-source

Initialize Behat and write down your use cases (in Gherkin_ syntax):

.. _Gherkin: http://docs.behat.org/guides/1.gherkin.html

::

    bin/behat --init
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

Write your code and watch your progress calling:

::

    bin/behat

Enjoy!
