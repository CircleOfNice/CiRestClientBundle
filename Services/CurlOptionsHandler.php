<?php
/**
 * This file is part of CircleRestClientBundle.
 *
 * CircleRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CircleRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CircleRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\RestClientBundle\Services;

use Circle\RestClientBundle\Traits\Exceptions;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class CurlOptionsHandler implements CurlOptionsHandlerInterface {

    use Exceptions;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $defaultOptions;

    /**
     * {@inheritdoc}
     *
     * @param array $defaultOptions
     */
    public function __construct(array $defaultOptions) {
        $this->validateOptions($defaultOptions);
        $this->defaultOptions   = $defaultOptions;
        $this->options          = $defaultOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function reset() {
        $this->options = $this->defaultOptions;
        return $this;
    }

    /**
     * @{@inheritdoc}
     */
    public function setOption($key, $value) {
        $this->validateOptions(array($key => $value));
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options) {
        foreach ($options as $key => $value) $this->setOption($key, $value);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * validates the given options
     *
     * @param  array $options
     * @return $this
     */
    private function validateOptions(array $options) {
        foreach ($options as $key => $value) {
            if (!is_int($key)) return $this->invalidArgumentException('Error while setting a curl option (http://php.net/manual/de/function.curl-setopt.php). Tried to set ' . $key . ' on curl resource.');
        }
        return $this;
    }
}