<?php

require __DIR__ .'/vendor/autoload.php';

$di = new \DI\ContainerBuilder();
$di->useAnnotations(true);
$di->addDefinitions(__DIR__.'/php-di-definitions.php');
$container = $di->build();

$directoryScanner = new \Zend\Code\Scanner\DirectoryScanner(__DIR__.'/src');

$definitionCompilers = array(
    'DI\Definition\ValueDefinition'   => new \DI\Definition\Compiler\ValueDefinitionCompiler(),
    'DI\Definition\FactoryDefinition' => new \DI\Definition\Compiler\FactoryDefinitionCompiler(),
    'DI\Definition\AliasDefinition'   => new \DI\Definition\Compiler\AliasDefinitionCompiler(),
    'DI\Definition\ClassDefinition'   => new \DI\Definition\Compiler\ClassDefinitionCompiler(),
);

$methodBody = '
switch ($name) {
';

$definitions = require __DIR__.'/php-di-definitions.php';

$names = array_merge(array_keys($definitions), $directoryScanner->getClassNames());
$names = array_unique($names);

foreach ($names as $name) {
    $definition = $container->getDefinitionManager()->getDefinition($name);

    $compiler = $definitionCompilers[get_class($definition)];

    $methodBody .= sprintf('
case \'%s\':
%s', $definition->getName(), $compiler->compile($definition));
}

$methodBody .= '
}';

$class = sprintf('
class SomeRandomContainerName {

private $services = array();

private function doCreate($name) {
%s
}
public function get($name) {
    if (!array_key_exists($name, $this->services)) {
        $value = $this->doCreate($name);
        if ($value instanceof \DI\Compiler\SharedEntry) {
            $value = $value->getValue();
        }
        $this->services[$name] = $value;
    }
    return $this->services[$name];
}
}', $methodBody);

$file = sprintf("<?php\n%s\nreturn new SomeRandomContainerName();\n", $class);

file_put_contents(__DIR__.'/cache/php-di/container.php', $file);