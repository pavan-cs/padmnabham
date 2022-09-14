<?php

namespace PavanCs\Padmnabham\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

// class ServiceDesignPattern extends Command
class ServiceDesignPattern extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service class';

        /**
     * Execute the console command.
     *
     * @return void
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
        return $this->resolveStubPath('/stubs/service.stub');
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
        // return public_path( $stub );
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
// dd($name);
        return 'app/Services/'.$name.'/'.$name.'Service.php';
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

    protected function repositoryRootNamespace($class)
    {
        return 'App\Repositories\\'.$class.'\\';
    }

    protected function getInterfacePath($class)
    {
        return $this->repositoryRootNamespace($class).$this->getInterfaceName($class);
    }

    protected function getInterfaceName($class)
    {
        return $class.'Interface';
    }
    

    /**
     * Get the service path
     *
     * @return string
     */
    public function servicePath()
    {
        return 'App/Services';
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
        
        if (! class_exists($class.'Facade') ) {
            $this->call('make:facade', ['name' => $class]);
        }

        if (! class_exists($class.'Repository') ) {
            $this->call('make:repository', ['name' => $class]);
        }

        return str_replace(
            ['{{ interfaceName }}','{{ interfacePath }}'], [$this->getInterfaceName($class), $this->getInterfacePath($class)], parent::buildClass($name)
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

        return str_replace(['DummyClass', '{{ class }}', '{{class}}'], $class.'Service', $stub);
    }



}
