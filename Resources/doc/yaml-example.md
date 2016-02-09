## YAML configuration example

Create an object you want to use as OpenGraph definition :

```php
// src/AppBundle/Entity/Post.php

class Post
{
    private $id;
    private $title;
    private $content;

    // ...
}
```

Add a YAML configuration file :

```yaml
# src/AppBundle/Resources/config/open-graph/Entity.Post.yml
# Filename must be the full class path in the bundle directory separeted by "."

AppBundle\Entity\Post:
    namespaces:
        og:  'http://ogp.me/ns#'

    nodes:
        title:
            -
                namespace: og
                tag:       title
```
