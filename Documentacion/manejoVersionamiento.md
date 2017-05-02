# ¿Cómo manejar el versionamiento?

La versión 1.0.0 define la API pública. La forma en que el número de versión se incrementa después de esta versión depende de esta API pública y de cómo cambia.

1.x.x --> versión principal - Major version
x.2.x --> versión menor - Menor version
x.x.3 --> versión de parche - Patch version

La versión del parche Z (x.y.Z | x> 0) DEBE incrementarse si sólo se introducen correcciones de errores compatibles con versiones anteriores. Una corrección de errores se define como un cambio interno que corrige un comportamiento incorrecto.

La versión menor Y (x.Y.z | x> 0) DEBE incrementarse si se introduce nueva funcionalidad compatible con versiones anteriores en la API pública. Debe ser incrementado si cualquier funcionalidad API pública está marcada como obsoleta. Se puede incrementar si se introducen nuevas funcionalidades o mejoras sustanciales en el código privado. Puede incluir cambios de nivel de parche. La versión de parche DEBE ser reajustada a 0 cuando la versión menor es incrementada.

La versión principal X (X.y.z | X> 0) DEBE ser incrementada si se introducen cambios incompatibles hacia atrás en la API pública. PUEDE incluir cambios menores y de nivel de parche. El parche y la versión secundaria DEBEN ser reajustados a 0 cuando la versión principal es incrementada.

## ¿Significado de la etiquetas?

## Unreleased Este espacio es para documentar las adiciones y cambios que se están realizando en la versión actual antes de convertirse en estable

### Added - Adiciones de funcionalidades en dicha versoón con respecto a las anteriores.

### Changed - Cambios de funcionalidades anteriores hacia dicha versión.

### Removed - Lo removido en dicha versión con respecto a las anteriores.

### Fixed - Erores encontrados en dicha versión.

