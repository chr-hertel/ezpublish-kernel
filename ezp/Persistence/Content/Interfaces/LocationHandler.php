<?php
/**
 * File containing the LocationHandler interface
 *
 * @copyright Copyright (C) 1999-2011 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version //autogentag//
 * @package ezp
 * @subpackage persistence_content
 */

namespace ezp\Persistence\Content\Interfaces;

/**
 * The LocationHandler interface defines operations on Location elements in the storage engine.
 *
 * @package ezp
 * @subpackage persistence_content
 */
interface LocationHandler
{
    /**
     * Loads the data for the location identified by $locationId.
     *
     * @param int $locationId
     * @return \ezp\Persistence\Content\Location
     */
    public function load( $locationId );

    /**
     * Copy location object identified by $sourceId, into destination identified by $destinationParentId.
     *
     * Performs a deep copy of the location identified by $sourceId and all of 
     * its child locations, copying the most recent published content object 
     * for each location to a new content object without any additional version 
     * information. Relations are not copied. URLs are not touched at all.
     *
     * @param mixed $sourceId
     * @param mixed $destinationParentId
     * @return Location the newly created Location.
     */
    public function copySubtree( $sourceId, $destinationParentId );

    /**
     * Moves location identified by $sourceId into new parent identified by $destinationParentId.
     *
     * Performs a full move of the location identified by $sourceId to a new
     * destination, identified by $destinationParentId. Relations do not need 
     * to be updated, since they refer to Content. URLs are not touched.
     *
     * @param mixed $sourceId
     * @param mixed $destinationParentId
     * @return boolean
     */
    public function move( $sourceId, $destinationParentId );

    /**
     * Sets a location to be invisible.
     *
     * @param mixed $id Location ID
     */
    public function hide( $id );

    /**
     * Sets a location to be visible.
     *
     * @param mixed $id
     */
    public function unHide( $id );

    /**
     * Swaps the content object being pointed to by a location object.
     *
     * Make the location identified by $locationId1 refer to the Content 
     * referred to by $locationId2 and vice versa.
     *
     * @param mixed $locationId1
     * @param mixed $locationId2
     * @return boolean
     */
    public function swap( $locationId1, $locationId2 );

    /**
     * Updates an existing location with data from $location.
     *
     * @param \ezp\Persistence\Content\Location\LocationUpdateStruct $location
     * @return boolean
     * @todo Create LocationUpdateStruct, which allows only to change data of a 
     *       location which can safely be changed (e.g. not the $parentId!).
     */
    public function update( \ezp\Persistence\Content\Location\LocationUpdateStruct $updateInfo );

    /**
     * Creates a new location for $contentId rooted at $parentId.
     *
     * @param mixed $contentId
     * @param mixed $parentId
     * @return \ezp\Persistence\Content\Location
     */
    public function createLocation( $contentId, $parentId );

    /**
     * Removes all Locations under and includin $locationId.
     *
     * Performs a recursive delete on the location identified by $locationId, 
     * including all of its child locations. Content which is not referred to 
     * by any other location is automatically removed. Content which looses its 
     * main Location will get the first of its other Locations assigned as the 
     * new main Location.
     *
     * @param mixed $locationId
     * @return boolean
     */
    public function removeSubtree( $locationId );

    /**
     * Sends a subtree to the trash
     *
     * Moves all locations in the subtree to the Trash. The associated content 
     * objects are left untouched.
     *
     * @param mixed $locationId
     * @return boolean
     */
    public function trashSubtree( $locationId );

    /**
     * Returns a trashed subtree to normal state.
     *
     * The affected subtree is now again part of matching content queries.
     *
     * @param mixed $locationId
     * @return boolean
     */
    public function untrashSubtree( $locationId );

    /**
     * Set section on all content objects in the subtree
     * 
     * @param mixed $locationId 
     * @param mixed $sectionId 
     * @return boolean
     */
    public function setSectionForSubtree( $locationId, $sectionId );

    /**
     * Create a (nice) url alias, $path pointing to $locationId, in $languageName.
     *
     * $alwaysAvailable controls whether the url alias is accessible in all
     * languages.
     *
     * @param string $path
     * @param string $locationId
     * @param string $languageName
     * @param bool $alwaysAvailable
     * @todo Create dedicated URL handler interface for this (OMS).
     */
    public function storeUrlAliasPath( $path, $locationId, $languageName = null, $alwaysAvailable = false );

    /**
     * Create a user chosen $alias pointing to $locationId in $languageName.
     *
     * If $languageName is null the $alias is created in the system's default
     * language. $alwaysAvailable makes the alias available in all languages.
     *
     * @param string $alias
     * @param int $locationId
     * @param boolean $forwarding
     * @param string $languageName
     * @param bool $alwaysAvailable
     * @return boolean
     * @todo Create dedicated URL handler interface for this (OMS).
     */
    public function createCustomUrlAlias( $alias, $locationId, $forwarding = false, $languageName = null, $alwaysAvailable = false );

    /**
     * Create a history url entry.
     *
     * History url entries constitutes a log of earlier url aliases to a location,
     * and allows old urls to hit the location, even if the current url is a
     * different one.
     *
     * @param $historicUrl
     * @param $locationId
     * @return boolean
     * @todo Create dedicated URL handler interface for this (OMS).
     */
    public function createUrlHistoryEntry( $historicUrl, $locationId );

    /**
     * List of url entries of $urlType, pointing to $locationId.
     *
     * @param $locationId
     * @param $urlType
     * @return mixed
     * @todo Create dedicated URL handler interface for this (OMS).
     */
    public function listUrlsForLocation( $locationId, $urlType );

    /**
     * Removes urls pointing to $locationId, identified by the element in $urlIdentifier.
     *
     * @param $locationId
     * @param array $urlIdentifier
     * @return boolean
     * @todo Create dedicated URL handler interface for this (OMS).
     */
    public function removeUrlsForLocation( $locationId, array $urlIdentifier );

    /**
     * Returns the full url alias to $locationId from /.
     *
     * @param $locationId
     * @param $languageCode
     * @return string
     * @todo Create dedicated URL handler interface for this (OMS).
     */
    public function getPath( $locationId, $languageCode );
}
?>
