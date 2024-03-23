<?php

namespace Awcodes\Scribble\Modals;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Reflector;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Mechanisms\ComponentRegistry;
use ReflectionClass;
use ReflectionException;

class Modals extends Component
{
    public ?string $activeComponent;

    public array $components = [];

    public function resetState(): void
    {
        $this->components = [];
        $this->activeComponent = null;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function openScribbleModal($component, $arguments = [], $modalAttributes = []): void
    {
        $requiredInterface = \Awcodes\Scribble\Modals\Contracts\ModalComponent::class;
        $componentClass = app(ComponentRegistry::class)->getClass($component);
        $reflect = new ReflectionClass($componentClass);

        if ($reflect->implementsInterface($requiredInterface) === false) {
            throw new Exception("[{$componentClass}] does not implement [{$requiredInterface}] interface.");
        }

        $id = md5($component . serialize($arguments));

        $arguments = collect($arguments)
            ->merge($this->resolveComponentProps($arguments, new $componentClass()))
            ->all();

        $this->components[$id] = [
            'name' => $component,
            'arguments' => $arguments,
            'modalAttributes' => array_merge([
                'alignment' => $componentClass::getAlignment()->value,
                'closeOnClickAway' => $componentClass::closeModalOnClickAway(),
                'closeOnEscape' => $componentClass::closeModalOnEscape(),
                'closeOnEscapeIsForceful' => $componentClass::closeModalOnEscapeIsForceful(),
                'dispatchCloseEvent' => $componentClass::dispatchCloseEvent(),
                'destroyOnClose' => $componentClass::destroyOnClose(),
                'isSlideOver' => $componentClass::isSlideOver(),
                'maxWidth' => $componentClass::getMaxWidth()->value,
                'slideDirection' => $componentClass::getSlideDirection()->value,
            ], $modalAttributes),
        ];

        $this->activeComponent = $id;

        $this->dispatch('activeScribbleModalComponentChanged', id: $id);
    }

    public function resolveComponentProps(array $attributes, Component $component): Collection
    {
        return $this->getPublicPropertyTypes($component)
            ->intersectByKeys($attributes)
            ->map(function ($className, $propName) use ($attributes) {
                return $this->resolveParameter($attributes, $propName, $className);
            });
    }

    /**
     * @throws BindingResolutionException
     */
    protected function resolveParameter($attributes, $parameterName, $parameterClassName): UrlRoutable
    {
        $parameterValue = $attributes[$parameterName];

        if ($parameterValue instanceof UrlRoutable) {
            return $parameterValue;
        }

        if (enum_exists($parameterClassName)) {
            $enum = $parameterClassName::tryFrom($parameterValue);

            if ($enum !== null) {
                return $enum;
            }
        }

        $instance = app()->make($parameterClassName);

        if (! $model = $instance->resolveRouteBinding($parameterValue)) {
            throw (new ModelNotFoundException())->setModel(get_class($instance), [$parameterValue]);
        }

        return $model;
    }

    public function getPublicPropertyTypes($component): Collection
    {
        return collect($component->all())
            ->map(function ($value, $name) use ($component) {
                return Reflector::getParameterClassName(new \ReflectionProperty($component, $name));
            })
            ->filter();
    }

    public function destroyScribbleComponent($id): void
    {
        unset($this->components[$id]);
    }

    public function getListeners(): array
    {
        return [
            'openScribbleModal',
            'destroyScribbleComponent',
        ];
    }

    public function render(): View
    {
        return view('scribble::modals');
    }
}
