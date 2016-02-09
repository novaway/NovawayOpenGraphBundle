## Extension Reference

### YAML

```yaml
# config.yml

novaway_open_graph:
    metadata:
        cache: file
        debug: "%kernel.debug%"
        file_cache:
            dir: "%kernel.cache_dir%/open_graph"

        # Using auto-detection, the mapping files for each bundle will be
        # expected in the Resources/config/open-graph directory.
        #
        # Example:
        # class: My\FooBundle\Entity\User
        # expected path: @MyFooBundle/Resources/config/open-graph/Entity.User.yml
        auto_detection: true

        # if you don't want to use auto-detection, you can also define the
        # namespace prefix and the corresponding directory explicitly
        directories:
            any-name:
                namespace_prefix: "My\\FooBundle"
                path: "@MyFooBundle/Resources/config/open-graph"
            another-name:
                namespace_prefix: "My\\BarBundle"
                path: "@MyBarBundle/Resources/config/open-graph"
```

### XML

```xml
<novaway-open-graph>
    <metadata
        cache="file"
        debug="%kernel.debug%"
        auto-detection="true">

        <file-cache dir="%kernel.cache_dir%/open-graph" />

        <!-- If auto-detection is enabled, mapping files for each bundle will
             be expected in the Resources/config/open-graph directory.

             Example:
             class: My\FooBundle\Entity\User
             expected path: @MyFooBundle/Resources/config/open-graph/Entity.User.yml
        -->
        <directory
            namespace-prefix="My\FooBundle"
            path="@MyFooBundle/Resources/config/open-graph" />
    </metadata>
</novaway-open-graph>
```
