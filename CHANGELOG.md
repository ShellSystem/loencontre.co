# Change Log 

Todos los cambios notables de este proyecto han sido documentados en este archivo.

El formato es basado en [Mantenga un CHANGELOG](http://keepachangelog.com/es-ES/0.3.0/)
aplicando también [Versionamiento semántico](http://semver.org/)

## Tenga en cuenta 

Este documento no es una copia del texto de los commits realizados sobre el código fuente, existe una distinción notable entre un commit y el change log: el propósito de un commit es el de documentar un cambio atómico en el cual el software evoluciona desde un estado hacia otro. El propósito del change log es el de documentar las diferencias notables entre estos estados.

[¿Cómo manejar el versionamiento?]

## [Unreleased]


### Added
- Nuevo diseño de interfaz para la aplicacion principal
- Distribucion de funciones de busqueda y nueva publicacion
- Simplificacion del formulario de nueva publicacion
- Obtencion de datos de contacto mediante login con facebook en el aplicativo
- Cambio de servidor, que permite cargas mas rapidas del cotenido
- Integracion y despliegue continuo sobre el servidor mediante travis

### Changed
- Opciones de búsqueda desplegables
- Campo de texto "Contacto" ahora es un TextArea

## [1.0.0] - 2017-03-29

### Added
- Formulario para agregar una nueva publicación con la imágen e información de contacto
- Extracción de texto en imagen del carné mediante API Microsoft Cognitive Services
- Procesamiento de lenguaje natural para obtener solo el nombre del texto con una probabilidad del mismo
- Búsqueda mediante nombre
- Búsqueda mediante rango de fecha (fecha inicial y final)
- Botón de contacto para desplegar información sobre localización de carné
- Se incluye el idioma inglés a la aplicación 

### Changed
- Cargado del número de página de las publicaciones ordenadas cronologicamente mediante API construida

### Removed
- Enlace a publicación original en Facebook desde la publicación seleccionada

### Fixed 
- Modal de Contacto no se visualizada cuando esta expandida la imágen

## 0.0.1 - 2017-03-19

### Added
- Cargado de publicaciones extraidas de Facebook ordenadas cronologicamente mediante archivo JSON 
- Paginación de publicaciones desde Frontend
- Enlace a publicación original en Facebook desde la publicación seleccionada


[Unreleased]: https://github.com/entregascontinuas/loencontre.co/compare/v1.0.0...development
[1.0.0]: https://github.com/entregascontinuas/loencontre.co/compare/v0.0.1...v1.0.0
[¿Cómo manejar el versionamiento?]: https://github.com/entregascontinuas/loencontre.co/tree/master/Documentacion/manejoVersionamiento.md
