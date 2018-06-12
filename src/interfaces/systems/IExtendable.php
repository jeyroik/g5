<?php
namespace tratabor\interfaces\systems;

use tratabor\interfaces\systems\states\IExtension;

/**
 * Interface IExtendable
 *
 * @package tratabor\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IExtendable
{
    const STAGE__EXTENDED_METHOD_CALL = 'extension___method_call';

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function isImplementsInterface(string $interface): bool;

    /**
     * @param string $interface
     * @param IExtension $interfaceImplementation
     *
     * @return bool true - interface registered, false - interface registration is failed
     */
    public function registerInterface(string $interface, IExtension $interfaceImplementation): bool;
}
