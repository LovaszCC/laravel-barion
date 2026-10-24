# Changelog

v1.1.0 - Laravel 13 support

-   Allow Laravel 13 (`illuminate/contracts` ^13.0, Testbench 11, Pest 5)
-   The Barion class can be resolved without configuration; a missing `BARION_POS_KEY` now throws a clear exception when calling the API instead of a `TypeError` on resolve
-   Added tests for starting a payment and reading its status

v1.0.0 - Initial release

-   Initial release
-   Added Barion class
-   Added Barion facade
-   Added Barion config
-   Added Barion enums
-   Added Barion tests
-   Added Barion documentation
