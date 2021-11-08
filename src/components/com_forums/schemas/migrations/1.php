<?php

/**
 * LICENSE: ##LICENSE##
 *
 * @package    Com_Forums
 * @subpackage Schema_Migration
 */

/**
 * Schema Migration
 *
 * @package    Com_Forums
 * @subpackage Schema_Migration
 */
class ComForumsSchemaMigration1 extends ComMigratorMigrationVersion
{
   /**
    * Called when migrating up
    */
    public function up()
    {
        dbexec('CREATE TABLE IF NOT EXISTS `#__forums_settings` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `person_id` int(11) DEFAULT NULL,
                  `signature` text,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8;');
    }

   /**
    * Called when rolling back a migration
    */
    public function down()
    {
        //add your migration here
    }
}