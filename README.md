# BackMarket Test Foucault

## Getting Started

Install locally docker and docker-compose

## Usage

Once installed, you can build your environment with:

    make build

Once built, you can start all the project requirements with:

    make start
    
You can enter the container with:

    make bash

Once in the container, you can use the following command for Molecule composition:

    $ bin/console bm:molecule:composition:extract 'K4[ON(SO3)2]2'
    
You can run unit tests with:

    make test
