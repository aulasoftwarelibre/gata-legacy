# GATA
> Gestión y Administración de Tareas del Aula (GATA)

<p align="center">

[![Travis](https://img.shields.io/travis/aulasoftwarelibre/gata.svg?style=for-the-badge)](https://github.com/aulasoftwarelibre/gata) [![Coveralls github](https://img.shields.io/coveralls/github/aulasoftwarelibre/gata.svg?style=for-the-badge)](aulasoftwarelibre/gata) [![GitHub license](https://img.shields.io/github/license/aulasoftwarelibre/gata.svg?style=for-the-badge)](https://github.com/aulasoftwarelibre/gata)

</p>

This project is a work in progress tasks management for the [Free Software Club](https://www.uco.es/aulasoftwarelibre) of the [University of Córdoba](https://www.uco.es/).

It is designed using Domain-Driven Design, Event Sourcing and CQRS.

## Installation

### Development

1. Copy .env.dist file in .env and update APP_SECRET and POSTGRES_PASSWORD.
1. Run `docker-compose up` or `docker-compose up -d`
1. Create the stream: `bin/console event-store:event-stream:create`

The docker-compose config file starts several required services:
    - Postgres server
    - One runner for each projection


### Testing

This project is not yet functional. Anyway, you can launch the tests:

    vendor/bin/phpspec run
    vendor/bin/behat
 
## Contributing

Any design suggestions are welcome. Feel free to open an issue to discuss anything you want to.
