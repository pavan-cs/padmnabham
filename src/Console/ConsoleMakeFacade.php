<?php

namespace PavanCs\Padmnabham\Console;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Console\Command;

class ConsoleMakeFacade extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:facade {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Facade for Service';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/facade.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return public_path( $stub );
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

        return 'app/Services/'.$name.'/'.$name.'Facade.php';
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'App\Services\\';
    }

    public function getServiceClass($class)
    {   
        $serviceClass = $class.'Service';
        return $this->rootNamespace().'\\'.$class.'\\'.$serviceClass;
    }

        /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {   
        
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        return str_replace(
            ['DummyTarget'], [$this->getServiceClass($class)], parent::buildClass($name)
        );
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class.'Facade', $stub);
    }


}
