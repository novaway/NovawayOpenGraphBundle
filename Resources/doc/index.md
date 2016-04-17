# Open Graph Bundle

This bundle integrates the [OpenGraph library](https://github.com/novaway/open-graph) into Symfony2.

## Installation

Simply run assuming you have installed composer :

```bash
$ php composer.phar require novaway/open-graph-bundle "^1.0"
```

## Configuration

Register the bundle in `app/AppKernel.php` :

``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new \Novaway\Bundle\OpenGraphBundle\NovawayOpenGraphBundle(),
    );
}
```

See all available (configuration options)[configuration-reference.md].

## Graph configuration

### Annotation

Just use annotation like it is explain in [OpenGraph library](https://github.com/novaway/open-graph) documentation.

### YAML

To use YAML graph configuration. You need to register your YAML file configuration in the `Resources/config/open-graph`
directory of your bundle.

After that, you can use YAML configuration like it is explain in [OpenGraph library](https://github.com/novaway/open-graph) documentation.

[See example](yaml-example.md).

## Usage

The `OpenGraphGenerator` is available as `novaway.open_graph.generator` service :

```php
// $myObject = ...
$graphGenerator = $this->get('novaway.open_graph.generator')->generate($myObject);
```

## Render OpenGraph in templates

The bundle comes with some Twig functions to render the graph into you templates.

* `renderNamespace` : Render graph prefix attributes (namespaces)
* `renderGraph` : Render <meta> tags for the graph
* `renderTag` : Render a specific tag of the graph
