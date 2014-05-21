<?php
/**
* Observer-SPL-PHP-Pattern
*
* Copyright (c) 2010, Julien Pauli <jpauli@php.net>.
* All rights reserved.
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions
* are met:
*
* * Redistributions of source code must retain the above copyright
* notice, this list of conditions and the following disclaimer.
*
* * Redistributions in binary form must reproduce the above copyright
* notice, this list of conditions and the following disclaimer in
* the documentation and/or other materials provided with the
* distribution.
*
* * Neither the name of Julien Pauli nor the names of his
* contributors may be used to endorse or promote products derived
* from this software without specific prior written permission.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
* "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
* LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
* FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
* COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
* BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
* LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
* CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
* LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
* ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
* POSSIBILITY OF SUCH DAMAGE.
*
* @package Observer
* @subpackage Listeners
* @author Julien Pauli <jpauli@php.net>
* @copyright 2010 Julien Pauli <jpauli@php.net>
* @license http://www.opensource.org/licenses/bsd-license.php BSD License
*/
namespace Observer\Listeners;
use Observer\Pattern;

/**
* Mock listener used for testing purpose
*
* @package Observer
* @subpackage Listeners
* @author Julien Pauli <jpauli@php.net>
* @copyright 2010 Julien Pauli <jpauli@php.net>
* @license http://www.opensource.org/licenses/bsd-license.php BSD License
* @version Release: @package_version@
*/
class Mock implements Pattern\Observer
{
    /**
     * Last error message publicly readable
     *
     * @var string
     */
    public $message;

    /**
     * If true, this object will throw an exception
     * on each update()
     *
     * @var bool
     */
    private $exception;

    /**
     *
     * @param bool $willException
     */
    public function __construct(bool $willException = false)
    {
        $this->exception = $willException;
    }

    /**
     * Observer
     *
     * @param Pattern\Subject $errorHandler
     */
    public function update(Pattern\Subject $errorHandler)
    {
        if ($this->exception) {
            throw new \RuntimeException("Mock generated an exception");
        }
        $this->message = $errorHandler->getError();
    }

    /**
     * Observer
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("class %s contains error '%s'", __CLASS__, $this->show());
    }
}