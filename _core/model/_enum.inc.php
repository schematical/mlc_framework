<?php
abstract class MLCEvent{
	const PAGE_LOAD = 'PAGE_LOAD';
	const EVENT_TRIGGER = 'EVENT_TRIGGER';
	const API_CALL = 'API_CALL';
	const AB_TEST_DISP = 'AB_TEST_DISP';
}
abstract class MLCRewriteAssetMode{
	const LOCAL = 'LOCAL';//Great for dev not prod lots of extra processing
	const S3 = 'S3';//Great for prod assuming you have S3 access
}
