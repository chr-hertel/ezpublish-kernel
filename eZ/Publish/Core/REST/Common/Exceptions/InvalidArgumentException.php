<?php
/**
 * File containing the InvalidArgumentException class
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 */

namespace eZ\Publish\Core\REST\Common\Exceptions;

use eZ\Publish\API\Repository\Exceptions\InvalidArgumentException as APIInvalidArgumentException;

/**
 *
 * This exception is thrown if a service method is called with an illegal or non appropriate value
 *
 */
class InvalidArgumentException extends APIInvalidArgumentException
{
}
