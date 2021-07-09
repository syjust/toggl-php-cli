# A Toggl Symfony php CLI commands set

## Available commands

* `toggl:time-entry:get`

## Available Toggl client implementations

* `TimeEntry::list`
* `TimeEntry::start` (not already tested)
* `TimeEntry::stop` (not already tested)
* `TimeEntry::retrieve` (not already tested)
* `TimeEntry::remove` (not already tested)
* `TimeEntry::update` (not already tested)
* `TimeEntry::bulkAddTags` (not already tested)
* `TimeEntry::bulkRemoveTags` (not already tested)

## TODO

* :warning: add default project id or allow to set it as client init parameters
* document installation & basic usages for this symfony project
* implements other Toggl endpoints
* split Toggl client & Toggle commands in 2 distincts bundles
