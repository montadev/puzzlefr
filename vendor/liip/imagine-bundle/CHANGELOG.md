# Changelog

This file contains a complete enumeration of all [pull requests](https://github.com/liip/LiipImagineBundle/pulls) merged
for a given releases. Unreleased, upcoming changes will be updated here periodically; reference the next release on our
[milestones](https://github.com/liip/LiipImagineBundle/milestones) page for the latest changes.

# 2.x

## [2.13.3](https://github.com/liip/LiipImagineBundle/tree/2.13.3)

- Prevent InvalidArgumentException from FileinfoMimeTypeGuesser when chain loading an image that is not a file ([revoltek-daniel](https://github.com/liip/LiipImagineBundle/pull/1614))

## [2.13.2](https://github.com/liip/LiipImagineBundle/tree/2.13.2)

- Remove deprecated spaceless filter from twig template ([JohJohan](https://github.com/liip/LiipImagineBundle/pull/1609))

## [2.13.1](https://github.com/liip/LiipImagineBundle/tree/2.13.1)

- Fix Json Manifest handling when manifest file does not exist yet ([AirBair](https://github.com/liip/LiipImagineBundle/pull/1600))

## [2.13.0](https://github.com/liip/LiipImagineBundle/tree/2.13.0)

- Support JsonManifestVersionStrategy that was added in Symfony 6 ([wouterSkepp](https://github.com/liip/LiipImagineBundle/pull/1529)).

## [2.12.3](https://github.com/liip/LiipImagineBundle/tree/2.12.3)

- Add alias for `Imagine\Image\ImagineInterface` to help autowiring ([dbu](https://github.com/liip/LiipImagineBundle/pull/1583)). 

## [2.12.2](https://github.com/liip/LiipImagineBundle/tree/2.12.2)

- Autoconfigure tags `'liip_imagine.filter.loader`, `liip_imagine.filter.post_processor` and `liip_imagine.binary.loader`
  and allow to specify these by class name in addition to service names ([homersimpsons](https://github.com/liip/LiipImagineBundle/pull/1486))
- Avoid PHP 8.3 warning with default empty prefix ([simonberger](https://github.com/liip/LiipImagineBundle/pull/1568))

## [2.12.1](https://github.com/liip/LiipImagineBundle/tree/2.12.1)

- Adjustments to install with Symfony 7 ([mbabker](https://github.com/liip/LiipImagineBundle/pull/1535))

## [2.12.0](https://github.com/liip/LiipImagineBundle/tree/2.12.0)

- Fix documentation filter command parameter name ([rdavaillaud](https://github.com/liip/LiipImagineBundle/pull/1515))
- Add return types in form ([garak](https://github.com/liip/LiipImagineBundle/pull/1518)) (fixes support of new Symfony versions)
- Improved documentation for flysystem adapter ([gregberger](https://github.com/liip/LiipImagineBundle/pull/1522))
- Drop support for PHP 7.1, minimum version is now 7.2.
- PHPStan and CS fixes

## [2.11.0](https://github.com/liip/LiipImagineBundle/tree/2.11.0)

- Compatibility with Symfony 6.3 (We do not expect users to extend a compiler passes or the DI extension of this bundle. If you did, you might need to adjust return types) ([mbabker](https://github.com/liip/LiipImagineBundle/pull/1514))
- Documentation improvements ([StevenRenaux](https://github.com/liip/LiipImagineBundle/pull/1511), [StevenRenaux](https://github.com/liip/LiipImagineBundle/pull/1510), [mysterty](https://github.com/liip/LiipImagineBundle/pull/1507))

## [2.10.0](https://github.com/liip/LiipImagineBundle/tree/2.10.0)

- Allow configuring the `vips` imagine driver provided by `rokka/imagine-vips` [\#1496](https://github.com/liip/LiipImagineBundle/pull/1496) ([PabloKowalczyk](https://github.com/PabloKowalczyk))
- Fix PHP 8.1 issues with `imagine/imagine` [\#1491](https://github.com/liip/LiipImagineBundle/pull/1491) ([LoicBoursin](https://github.com/LoicBoursin))

## [2.9.0](https://github.com/liip/LiipImagineBundle/tree/2.9.0)

- Fix Symfony 6.1 deprecations [\#1472](https://github.com/liip/LiipImagineBundle/pull/1472) ([willemverspyck](https://github.com/willemverspyck))
- Allow extra keys to generate correct Symfony configuration class [\#1484](https://github.com/liip/LiipImagineBundle/pull/1484) ([bobvandevijver](https://github.com/bobvandevijver))

## [2.8.0](https://github.com/liip/LiipImagineBundle/tree/2.8.0)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.6...2.8.0)

- adjust codestyle to newest php-cs-fixer [\#1468](https://github.com/liip/LiipImagineBundle/pull/1468) ([dbu](https://github.com/dbu))
- feat: add a cwebp post-processor for WebP images [\#1466](https://github.com/liip/LiipImagineBundle/pull/1466) ([DjLeChuck](https://github.com/DjLeChuck))
- return values from the aws client are not used [\#1461](https://github.com/liip/LiipImagineBundle/pull/1461) ([dbu](https://github.com/dbu))
- file\_get\_contents might return false. related to \#1452 [\#1453](https://github.com/liip/LiipImagineBundle/pull/1453) ([dbu](https://github.com/dbu))
- Use bin/console in documentation [\#1448](https://github.com/liip/LiipImagineBundle/pull/1448) ([tbredillet](https://github.com/tbredillet))

## [2.7.6](https://github.com/liip/LiipImagineBundle/tree/2.7.6) (2022-01-14)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.5...2.7.6)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.5...2.7.6)

- Allow Flysystem 3.0 [\#1445](https://github.com/liip/LiipImagineBundle/pull/1445) ([mbabker](https://github.com/mbabker))

## [2.7.5](https://github.com/liip/LiipImagineBundle/tree/2.7.5) (2022-01-11)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.4...2.7.5)

- Fix animated gifs can not be transformed to the webp format [\#1444](https://github.com/liip/LiipImagineBundle/pull/1444) ([Yoann-TYT](https://github.com/Yoann-TYT))

## [2.7.4](https://github.com/liip/LiipImagineBundle/tree/2.7.4) (2021-12-27)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.3...2.7.4)

- Fix confusing deprecation message [\#1443](https://github.com/liip/LiipImagineBundle/pull/1443) ([bastien70](https://github.com/bastien70))

## [2.7.3](https://github.com/liip/LiipImagineBundle/tree/2.7.3) (2021-12-03)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.2...2.7.3)

- Allow Symfony 6.0 [\#1431](https://github.com/liip/LiipImagineBundle/pull/1431) ([franmomu](https://github.com/franmomu))

## [2.7.2](https://github.com/liip/LiipImagineBundle/tree/2.7.2) (2021-11-11)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.1...2.7.2)

- Address PHP 8.1 deprecations [\#1427](https://github.com/liip/LiipImagineBundle/pull/1427) ([franmomu](https://github.com/franmomu))

## [2.7.1](https://github.com/liip/LiipImagineBundle/tree/2.7.1) (2021-11-02)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.7.0...2.7.1)

- Bugfix: Don't resolve to webp in the controller if webp generation is disabled [\#1410](https://github.com/liip/LiipImagineBundle/pull/1410) ([mynameisbogdan](https://github.com/mynameisbogdan) / [dbu](https://github.com/dbu))

## [2.7.0](https://github.com/liip/LiipImagineBundle/tree/2.7.0) (2021-10-28)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.6.1...2.7.0)

- The image controller now redirects with 302 instead of 301 by default [\#1404](https://github.com/liip/LiipImagineBundle/pull/1404) ([dbu](https://github.com/dbu))
  You can configure the `controller.redirect_response_code` setting to revert to 301 if you are sure this will not cause problems with your setup.
- Create Lazy-Loaded Twig Extension [\#1376](https://github.com/liip/LiipImagineBundle/pull/1376) ([emmanuelballery](https://github.com/emmanuelballery))
- lazy twig extension: handle asset versioning, added imagine\_filter\_cache, better test coverage [\#1397](https://github.com/liip/LiipImagineBundle/pull/1397) ([dbu](https://github.com/dbu))
- asset versions: have & instead of second ? when image url already has a query string [\#1402](https://github.com/liip/LiipImagineBundle/pull/1402) ([dbu](https://github.com/dbu))
- fix handling of + in image names, added some functional tests [\#1391](https://github.com/liip/LiipImagineBundle/pull/1391) ([dbu](https://github.com/dbu))
- Allow installing doctrine/cache 2.0 [\#1395](https://github.com/liip/LiipImagineBundle/pull/1395) ([dbu](https://github.com/dbu))
- \[Flysystem Resolver\] Allowing "noPredefinedVisibility" for the visibility config parameter [\#1389](https://github.com/liip/LiipImagineBundle/pull/1389) ([comxd](https://github.com/comxd))
- Change registering the form theme to prepend the configuration [\#1387](https://github.com/liip/LiipImagineBundle/pull/1387) ([mbabker](https://github.com/mbabker))
- Fix service definitions for mime and extension guessers [\#1379](https://github.com/liip/LiipImagineBundle/pull/1379) ([mbabker](https://github.com/mbabker))
- Allow installing doctrine/cache 2.0 [\#1375](https://github.com/liip/LiipImagineBundle/pull/1375) ([alcaeus](https://github.com/alcaeus))
- Messenger support [\#1360](https://github.com/liip/LiipImagineBundle/pull/1360) ([mynameisbogdan](https://github.com/mynameisbogdan))
- Add Twig filter for resolve path to cache [\#1348](https://github.com/liip/LiipImagineBundle/pull/1348) ([peter-gribanov](https://github.com/peter-gribanov))
- Add WebP client side resolving section in documentation [\#1380](https://github.com/liip/LiipImagineBundle/pull/1380) ([peter-gribanov](https://github.com/peter-gribanov))
- Generate WebP in liip:imagine:cache:resolve CLI command and async resolve cache messages [\#1347](https://github.com/liip/LiipImagineBundle/pull/1347) ([peter-gribanov](https://github.com/peter-gribanov))
- Add FormatExtensionResolver [\#1300](https://github.com/liip/LiipImagineBundle/pull/1300) ([ossinkine](https://github.com/ossinkine))
- Documentation improvements [\#1396](https://github.com/liip/LiipImagineBundle/pull/1396), [\#1399](https://github.com/liip/LiipImagineBundle/pull/1399), [\#1400](https://github.com/liip/LiipImagineBundle/pull/1400), [\#1403](https://github.com/liip/LiipImagineBundle/pull/1403), [\#1401](https://github.com/liip/LiipImagineBundle/pull/1401) ([dbu](https://github.com/dbu))
- Add doc for disabling auth on filter controllers [\#1383](https://github.com/liip/LiipImagineBundle/pull/1383) ([mbabker](https://github.com/mbabker))

## [2.6.1](https://github.com/liip/LiipImagineBundle/tree/2.6.1) (2021-05-22)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.6.0...2.6.1)

- php-cs-fixer 3x update [\#1377](https://github.com/liip/LiipImagineBundle/pull/1377) ([lsmith77](https://github.com/lsmith77))
- $ should not be there [\#1373](https://github.com/liip/LiipImagineBundle/pull/1373) ([Gamesh](https://github.com/Gamesh))
- Undefined quality key. Fixes \#1310 [\#1370](https://github.com/liip/LiipImagineBundle/pull/1370) ([phproberto](https://github.com/phproberto))

## [2.6.0](https://github.com/liip/LiipImagineBundle/tree/2.6.0) (2021-03-31)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.5.0...2.6.0)

- \[Doc\] Simplified the "strong" role [\#1361](https://github.com/liip/LiipImagineBundle/pull/1361) ([javiereguiluz](https://github.com/javiereguiluz))
- Flysystem v2 support [\#1357](https://github.com/liip/LiipImagineBundle/pull/1357), [\#1359](https://github.com/liip/LiipImagineBundle/pull/1359), [\#1349](https://github.com/liip/LiipImagineBundle/pull/1349)  ([mynameisbogdan](https://github.com/mynameisbogdan)) and ([Warxcell](https://github.com/Warxcell))
- Don't use cs2pr to report PHP-CS-Fixer suggestions [\#1355](https://github.com/liip/LiipImagineBundle/pull/1355) ([fbourigault](https://github.com/fbourigault))

## [2.5.0](https://github.com/liip/LiipImagineBundle/tree/2.5.0) (2021-02-08)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.4.0...2.5.0)

- Fix missing port in url parsing [\#1353](https://github.com/liip/LiipImagineBundle/pull/1353) ([dbalabka](https://github.com/dbalabka))
- Suggest symfony/templating instead of requiring deprecated component [\#1350](https://github.com/liip/LiipImagineBundle/pull/1350) ([ossinkine](https://github.com/ossinkine))
- Various cleanups [\#1345](https://github.com/liip/LiipImagineBundle/pull/1345) ([fbourigault](https://github.com/fbourigault))
- Retry coveralls coverage upload [\#1344](https://github.com/liip/LiipImagineBundle/pull/1344) ([fbourigault](https://github.com/fbourigault))
- Correct comment of unsecured connection [\#1340](https://github.com/liip/LiipImagineBundle/pull/1340) ([peter-gribanov](https://github.com/peter-gribanov))
- Add missing sprintf placeholder [\#1339](https://github.com/liip/LiipImagineBundle/pull/1339) ([fbourigault](https://github.com/fbourigault))
- Depend on doctrine/persistence instead of doctrine/orm [\#1337](https://github.com/liip/LiipImagineBundle/pull/1337) ([fbourigault](https://github.com/fbourigault))
- allow to use Doctrine/Persistence:^2 [\#1305](https://github.com/liip/LiipImagineBundle/pull/1305) ([jkabat](https://github.com/jkabat))
- Enable WebP support in tests [\#1329](https://github.com/liip/LiipImagineBundle/pull/1329) ([fbourigault](https://github.com/fbourigault))
- Not resolve WebP in CacheManager [\#1333](https://github.com/liip/LiipImagineBundle/pull/1333) ([peter-gribanov](https://github.com/peter-gribanov))
- Test WebP configuration [\#1326](https://github.com/liip/LiipImagineBundle/pull/1326) ([peter-gribanov](https://github.com/peter-gribanov))
- Add note for using 302 redirect in HTTP connections for WebP [\#1334](https://github.com/liip/LiipImagineBundle/pull/1334) ([peter-gribanov](https://github.com/peter-gribanov))
- Support PHP 8 [\#1325](https://github.com/liip/LiipImagineBundle/pull/1325) ([nicwortel](https://github.com/nicwortel))

## [2.4.0](https://github.com/liip/LiipImagineBundle/tree/2.4.0) (2020-12-16)

[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.3.1...2.4.0)

- Replace assertContains with assertStringContainsString [\#1317](https://github.com/liip/LiipImagineBundle/pull/1317) ([fbourigault](https://github.com/fbourigault))
- Fix skipped functional tests with Symfony 5.x [\#1316](https://github.com/liip/LiipImagineBundle/pull/1316) ([fbourigault](https://github.com/fbourigault))
- Fix tests related to a missing configuration entry [\#1315](https://github.com/liip/LiipImagineBundle/pull/1315) ([fbourigault](https://github.com/fbourigault))
- Update basic-usage.rst [\#1311](https://github.com/liip/LiipImagineBundle/pull/1311) ([Aerendir](https://github.com/Aerendir))
- Add WebP image conversion support [\#1307](https://github.com/liip/LiipImagineBundle/pull/1307) ([peter-gribanov](https://github.com/peter-gribanov))
- Update aws\_s3.rst with clarifications re service setup [\#1302](https://github.com/liip/LiipImagineBundle/pull/1302) ([manuelkiessling](https://github.com/manuelkiessling))
- Fix RST documentation compilation errors introduced at various times in past [\#1301](https://github.com/liip/LiipImagineBundle/pull/1301) ([robfrawley](https://github.com/robfrawley))
- fix styleci config [\#1299](https://github.com/liip/LiipImagineBundle/pull/1299) ([dbu](https://github.com/dbu))
- Allow PDF files for the thumbnail generation [\#1297](https://github.com/liip/LiipImagineBundle/pull/1297) ([ajay-gupta](https://github.com/ajay-gupta))
- Extend WatermarkFilter with multiple option [\#1281](https://github.com/liip/LiipImagineBundle/pull/1281) ([tzemp](https://github.com/tzemp))
- expose reference type further up following PR 1224 [\#1263](https://github.com/liip/LiipImagineBundle/pull/1263) ([uwej711](https://github.com/uwej711))

## [2.3.1](https://github.com/liip/LiipImagineBundle/tree/2.3.1) Symfony 5.1 support (2020-06-26)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.3.0...2.3.1)

**Merged pull requests:**
- Pass caught exception to give more insight on the original problem [\#1262](https://github.com/liip/LiipImagineBundle/pull/1262) ([pyrech](https://github.com/pyrech))
- Don't throw top-level exceptions [\#1267](https://github.com/liip/LiipImagineBundle/pull/1267) ([mwoynarski](https://github.com/mwoynarski))
- Fix typos in documentation [\#1278](https://github.com/liip/LiipImagineBundle/pull/1278) ([pgrimaud](https://github.com/pgrimaud))
- Update documentation for Symfony 5.x [\#1276](https://github.com/liip/LiipImagineBundle/pull/1276) ([BlueSkunka](https://github.com/BlueSkunka))
- Specify Twig package in the required dependencies [\#1273](https://github.com/liip/LiipImagineBundle/pull/1273) ([emulienfou](https://github.com/emulienfou))
- Fix symfony 5.1 deprecations [\#1282](https://github.com/liip/LiipImagineBundle/pull/1282) ([mynameisbogdan](https://github.com/mynameisbogdan))
- Clean up unused dependencies [\#1290](https://github.com/liip/LiipImagineBundle/pull/1290) ([dbu](https://github.com/dbu))

## [2.3.0](https://github.com/liip/LiipImagineBundle/tree/2.3.0) Symfony 5 (2020-01-04)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.2.0...2.3.0)

**Merged pull requests:**
- Upgrading to Symfony5 [\#1246](https://github.com/liip/LiipImagineBundle/pull/1246) ([michellesanver](https://github.com/michellesanver))
- Upgrading to Symfony5 [\#1257](https://github.com/liip/LiipImagineBundle/pull/1256) ([weaverryan](https://github.com/weaverryan))
- Eliminate root_dir usage [\#1255](https://github.com/liip/LiipImagineBundle/pull/1255) ([Guite](https://github.com/guite))
- Remove non-functional allow\_upscale reference [\#1257](https://github.com/liip/LiipImagineBundle/pull/1257) ([Yopai](https://github.com/Yopai))
- Remove unused packages [\#1251](https://github.com/liip/LiipImagineBundle/pull/1251) ([franmomu](https://github.com/franmomu))
- Fixing bug where apply tag was used but allowed non-supported Twig versions [\#1249](https://github.com/liip/LiipImagineBundle/pull/1249) ([weaverryan](https://github.com/weaverryan))
- Use PHPUnit 7.5 and test clean up [\#1243](https://github.com/liip/LiipImagineBundle/pull/1243) ([franmomu](https://github.com/franmomu))
- Fix RemoveCacheCommand with empty path [\#1239](https://github.com/liip/LiipImagineBundle/pull/1239) ([franmomu](https://github.com/franmomu))
- Update UPGRADE.md with a bc break notice [\#1235](https://github.com/liip/LiipImagineBundle/pull/1235) ([franmomu](https://github.com/franmomu))
- Add missing fixed loader service [\#1232](https://github.com/liip/LiipImagineBundle/pull/1232) ([franmomu](https://github.com/franmomu))
- Update orientation documentation [\#1231](https://github.com/liip/LiipImagineBundle/pull/1231) ([franmomu](https://github.com/franmomu))

**Closed issues:**

- Thumbnails creation: 500 internal server error [\#1254](https://github.com/liip/LiipImagineBundle/issues/1254)
- Image "auto\_rotate"-filter is not rotating my images correctly [\#1247](https://github.com/liip/LiipImagineBundle/issues/1247)
- A tree builder without a root node is deprecated since Symfony 4.2 and will not be supported anymore in 5.0. [\#1234](https://github.com/liip/LiipImagineBundle/issues/1234)
- Resolve cache images in background not working [\#1228](https://github.com/liip/LiipImagineBundle/issues/1228)
- Create thumb image without storing  [\#1204](https://github.com/liip/LiipImagineBundle/issues/1204)
- Version/milestones? [\#1186](https://github.com/liip/LiipImagineBundle/issues/1186)
- Thumbnail with fixed size [\#1181](https://github.com/liip/LiipImagineBundle/issues/1181)
- Configure enqueue [\#1142](https://github.com/liip/LiipImagineBundle/issues/1142)
- Access FilterService from another service in Symfony 4 [\#1135](https://github.com/liip/LiipImagineBundle/issues/1135)
- Cache images are not found [\#1061](https://github.com/liip/LiipImagineBundle/issues/1061)
- help with amazons3 and gaufrette loader [\#776](https://github.com/liip/LiipImagineBundle/issues/776)
- Work with images from database [\#771](https://github.com/liip/LiipImagineBundle/issues/771)
- Crop image into circle [\#752](https://github.com/liip/LiipImagineBundle/issues/752)
- applyMask\(\) not working [\#750](https://github.com/liip/LiipImagineBundle/issues/750)
- Redirection to login if cached image not created [\#747](https://github.com/liip/LiipImagineBundle/issues/747)
- defne public route [\#743](https://github.com/liip/LiipImagineBundle/issues/743)
- Auto rotate problem in real server [\#741](https://github.com/liip/LiipImagineBundle/issues/741)
- image not appear \(Source image could not be found\) [\#740](https://github.com/liip/LiipImagineBundle/issues/740)
- Can't clear cache for previously existing thumbs ? [\#739](https://github.com/liip/LiipImagineBundle/issues/739)
- Wrong Environment loaded by Liip \(Always Prod\) [\#738](https://github.com/liip/LiipImagineBundle/issues/738)
- Automatic rotation in conjunction with thumbnails [\#737](https://github.com/liip/LiipImagineBundle/issues/737)
- Cache paths 404 response since upgrade to AWS SDK 3 [\#726](https://github.com/liip/LiipImagineBundle/issues/726)
- Path Problems when imagename from variable [\#724](https://github.com/liip/LiipImagineBundle/issues/724)
- Cache image not generated if app\_dev.php is not in url [\#716](https://github.com/liip/LiipImagineBundle/issues/716)
- Can't resize if the desired size is \< to thumbnail size [\#710](https://github.com/liip/LiipImagineBundle/issues/710)
- Custom StreamLoader of LiipImagineBundle never instantiated [\#698](https://github.com/liip/LiipImagineBundle/issues/698)
- Sometimes when production cache is being generated, resources directory is incorrect [\#689](https://github.com/liip/LiipImagineBundle/issues/689)
- Availablity of Google Cloud Storage Resolver like AwsS3Resolver [\#666](https://github.com/liip/LiipImagineBundle/issues/666)
- JpegOptimPostProcessor options [\#589](https://github.com/liip/LiipImagineBundle/issues/589)
- Trim filter [\#586](https://github.com/liip/LiipImagineBundle/issues/586)
- Get filesystem path from cache manager [\#572](https://github.com/liip/LiipImagineBundle/issues/572)
- how to apply grayscale filter on an image? [\#540](https://github.com/liip/LiipImagineBundle/issues/540)
- Rotation issue [\#532](https://github.com/liip/LiipImagineBundle/issues/532)
- S3 GET Parameters not stripped [\#529](https://github.com/liip/LiipImagineBundle/issues/529)
- Issue with path on Windows? [\#527](https://github.com/liip/LiipImagineBundle/issues/527)
- hotlink cache image from outside [\#494](https://github.com/liip/LiipImagineBundle/issues/494)
- Opposite of inset? [\#484](https://github.com/liip/LiipImagineBundle/issues/484)
- Thumbnail without redirect. How? [\#465](https://github.com/liip/LiipImagineBundle/issues/465)
- couldn't get working watermark [\#459](https://github.com/liip/LiipImagineBundle/issues/459)
- Symfony, Liip Imagine bundle not working on server in prod environment [\#450](https://github.com/liip/LiipImagineBundle/issues/450)
- Apply Filter In Command [\#438](https://github.com/liip/LiipImagineBundle/issues/438)
- Applying filters to high resolution images does not work [\#431](https://github.com/liip/LiipImagineBundle/issues/431)
- Upscale improvements [\#428](https://github.com/liip/LiipImagineBundle/issues/428)
- PSD conversion to jpg  [\#426](https://github.com/liip/LiipImagineBundle/issues/426)
- S3 store folder path [\#347](https://github.com/liip/LiipImagineBundle/issues/347)
- need https option for aws stream [\#335](https://github.com/liip/LiipImagineBundle/issues/335)
- Including filters inside filters [\#255](https://github.com/liip/LiipImagineBundle/issues/255)
- improve error message [\#192](https://github.com/liip/LiipImagineBundle/issues/192)
- Resize and crop with cropping options [\#72](https://github.com/liip/LiipImagineBundle/issues/72)

## [2.2.0](https://github.com/liip/LiipImagineBundle/tree/2.2.0) (2019-10-04)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.1.0...2.2.0)

- Allow unresolvable data roots for filesystem locator ([robfrawley](https://github.com/robfrawley))
- Add "fixed-size" filter implementation ([peter-gribanov](https://github.com/peter-gribanov))
- Only use actual path without any query parameters from the url ([TiMESPLiNTER](https://github.com/TiMESPLiNTER))
- Add missing ImageType::getBlockPrefix() method ([EmmanuelVella](https://github.com/EmmanuelVella))
- Replace app/console with bin/console ([welcoMattic](https://github.com/welcoMattic))
- Fix Symfony 4.2 Deprecation Warnings ([hjanuschka](https://github.com/hjanuschka))
- Fix special characters encoding in URL path ([dbalabka](https://github.com/dbalabka))
- Update imagine/imagine dependency to 1.1 ([maximgubar](https://github.com/maximgubar))
- Only use actual path without any query parameters from the url ([maximgubar](https://github.com/maximgubar))
  See also UPGRADE.md - if you used URLs with domains to get your images, you will need to adjust.
- __\[Dependency Injection\]__ Add aliases for data and filter manager ([fpaterno](https://github.com/fpaterno))
- Use Autorotate Filter from Imagine library ([franmomu](https://github.com/franmomu))
- Fix Mime deprecations for Symfony 4 ([franmomu](https://github.com/franmomu))

## [2.1.0](https://github.com/liip/LiipImagineBundle/tree/2.1.0) (2018-07-10)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/2.0.0...2.1.0)

- added bypassing of loaders and resolvers configuration [\#1110](https://github.com/liip/LiipImagineBundle/pull/1110) ([maximgubar](https://github.com/maximgubar))
- php-cs-fixer: skip native constants check [\#1107](https://github.com/liip/LiipImagineBundle/pull/1107) ([maximgubar](https://github.com/maximgubar))
- added ability to inject custom drivers [\#1105](https://github.com/liip/LiipImagineBundle/pull/1105) ([maximgubar](https://github.com/maximgubar))
- __\[Filters\]__ __\[Config\]__ __\[DI\]__ Add Filter configuration class as public service [\#1098](https://github.com/liip/LiipImagineBundle/pull/1098) ([maximgubar](https://github.com/maximgubar))
- __\[Data Loader\]__ __\[Docs\]__ Add chain loader implementation and related docs [\#1096](https://github.com/liip/LiipImagineBundle/pull/1096) ([robfrawley](https://github.com/robfrawley))
- Added transparency to background filter [\#1095](https://github.com/liip/LiipImagineBundle/pull/1095) ([nielstholenaar](https://github.com/nielstholenaar))
- __\[Docs\]__ Add routing removal in Upgrade file [\#1092](https://github.com/liip/LiipImagineBundle/pull/1092) ([tifabien](https://github.com/tifabien))
- __\[Tests\]__ __\[Deprecation\]__ Updated bundle notation to accommodate Symfony 4.1 and set browser client to not catch exceptions [\#1090](https://github.com/liip/LiipImagineBundle/pull/1090) ([robfrawley](https://github.com/robfrawley))
- moved GitHub-specific documents into .github and split issue template [\#1089](https://github.com/liip/LiipImagineBundle/pull/1089) ([maximgubar](https://github.com/maximgubar))
- fix annotation [\#1072](https://github.com/liip/LiipImagineBundle/pull/1072) ([auipga](https://github.com/auipga))

## [2.0.0](https://github.com/liip/LiipImagineBundle/tree/2.0.0) (2018-04-30)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.9.1...2.0.0)

- __\[Post Processors\]__ __\[Filters\]__ __\[BC BREAK\]__ Remove configurable post processor interface for one interface and cleanup filter manager [\#1075](https://github.com/liip/LiipImagineBundle/pull/1075) ([robfrawley](https://github.com/robfrawley))
- __\[Meta\]__ Add code of conduct and update contributor instructions [\#1071](https://github.com/liip/LiipImagineBundle/pull/1071) ([robfrawley](https://github.com/robfrawley))
- __\[Dependencies\]__ Update imagine/imagine to ^0.7.1,\<0.8 [\#1067](https://github.com/liip/LiipImagineBundle/pull/1067) ([robfrawley](https://github.com/robfrawley))
- __\[Documentation\]__ Correct indentation in AWS-S3 cache resolver documentation [\#1063](https://github.com/liip/LiipImagineBundle/pull/1063) ([robfrawley](https://github.com/robfrawley))
- __\[CS\]__ Globally update code style using new php-cs-fixer rules [\#1058](https://github.com/liip/LiipImagineBundle/pull/1058) ([robfrawley](https://github.com/robfrawley))
- __\[CI\]__ __\[CS\]__ Add a required php-cs-fixer build run to Travis matrix [\#1057](https://github.com/liip/LiipImagineBundle/pull/1057) ([robfrawley](https://github.com/robfrawley))
- __\[Tests\]__ Add missing PHPUnit @covers annotations [\#1054](https://github.com/liip/LiipImagineBundle/pull/1054) ([robfrawley](https://github.com/robfrawley))
- __\[CI\]__ Move the "simple-phpunit install" command to Travis install section to collapse the output [\#1048](https://github.com/liip/LiipImagineBundle/pull/1048) ([dbu](https://github.com/dbu))
- __\[CS\]__ __\[Dependencies\]__ __\[Dependency Injection\]__ __\[Form\]__ __\[General\]__ Update compiler log format, remove legacy code, remove deprecated, fix docblocks/style, general Travis config, upgrade coveralls, and general fixes [\#1047](https://github.com/liip/LiipImagineBundle/pull/1047) ([robfrawley](https://github.com/robfrawley))
- __\[CS\]__ Changes to support new php-cs-fixer rule set [\#1046](https://github.com/liip/LiipImagineBundle/pull/1046) ([robfrawley](https://github.com/robfrawley))
- __\[Dependencies\]__ Revert php-cs-fixer development dependency removal [\#1045](https://github.com/liip/LiipImagineBundle/pull/1045) ([dbu](https://github.com/dbu))
- __\[Dependency Injection\]__ Detect proper web root path based on Symfony kernel version [\#1044](https://github.com/liip/LiipImagineBundle/pull/1044) ([robfrawley](https://github.com/robfrawley))
- __\[Async\]__ __\[DI\]__ Make resolve\_cache\_processor a public service [\#1043](https://github.com/liip/LiipImagineBundle/pull/1043) ([silverbackdan](https://github.com/silverbackdan))
- __\[CS\]__ Implement new php-cs-fixer rules and related code cleanup [\#1040](https://github.com/liip/LiipImagineBundle/pull/1040) ([sebastianblum](https://github.com/sebastianblum))
- __\[Dependency Injection\]__ Change cache manager from private service to public to fix deprecation [\#1038](https://github.com/liip/LiipImagineBundle/pull/1038) ([fabianoroberto](https://github.com/fabianoroberto))
- __\[CI\]__ Extend and enhance Travis build matrix [\#1035](https://github.com/liip/LiipImagineBundle/pull/1035) ([sebastianblum](https://github.com/sebastianblum))
- __\[Dependencies\]__ Remove unused php-cs-fixer from require-dev [\#1031](https://github.com/liip/LiipImagineBundle/pull/1031) ([dbu](https://github.com/dbu))
- __\[Tests\]__ __\[CI\]__ __\[Dependencies\]__ Refactored Travis config to use simple-phpunit and remove phpunit Composer dependency [\#1029](https://github.com/liip/LiipImagineBundle/pull/1029) ([sebastianblum](https://github.com/sebastianblum))
- __\[Documentation\]__ Fix binary name in png-quant.rst [\#1026](https://github.com/liip/LiipImagineBundle/pull/1026) ([bruno-ds](https://github.com/bruno-ds))
- __\[Post-Processors\]__ Replaced ProcessBuilder with Process and add additional tests [\#1025](https://github.com/liip/LiipImagineBundle/pull/1025) ([fabianbloching](https://github.com/fabianbloching))
- __\[Tests\]__ Fix tests on Symfony 3.4 and 4.0 [\#1023](https://github.com/liip/LiipImagineBundle/pull/1023) ([lsmith77](https://github.com/lsmith77))
- __\[Dependency Injection\]__ Add alias for cache manager [\#1022](https://github.com/liip/LiipImagineBundle/pull/1022) ([garak](https://github.com/garak))
- __\[Documentation\]__ Align example and description quality values in png-quant.rst [\#1020](https://github.com/liip/LiipImagineBundle/pull/1020) ([qkdreyer](https://github.com/qkdreyer))
- __\[Dependency Injection\]__ Change imagine controller from private service to public service [\#1019](https://github.com/liip/LiipImagineBundle/pull/1019) ([michaelperrin](https://github.com/michaelperrin))
- __\[Dependencies\]__ Enable Symfony 4.0 support [\#1013](https://github.com/liip/LiipImagineBundle/pull/1013) ([lsmith77](https://github.com/lsmith77))
- __\[Dependencies\]__ Enable Symfony 4.0 support [\#1010](https://github.com/liip/LiipImagineBundle/pull/1010) ([llaakkkk](https://github.com/llaakkkk))
- __\[Tests\]__ __\[CI\]__ Add PHP 7.2 to Travis test matrix [\#1009](https://github.com/liip/LiipImagineBundle/pull/1009) ([dbu](https://github.com/dbu))
- __\[Documentation\]__ Fix bucket parameter nesting level in aws_s3.rst YAML example [\#996](https://github.com/liip/LiipImagineBundle/pull/996) ([bocharsky-bw](https://github.com/bocharsky-bw))
- __\[Data Loader\]__ __\[Data Locator\]__ __\[Dependency Injection\]__ Pass root paths to FileSystemLocator during construction [\#930](https://github.com/liip/LiipImagineBundle/pull/930) ([rpkamp](https://github.com/rpkamp))
- __\[Dependency Injection\]__ __\[Filter\]__ Implement filter service abstraction for creating images [\#922](https://github.com/liip/LiipImagineBundle/pull/922) ([rpkamp](https://github.com/rpkamp))


## [1.9.1](https://github.com/liip/LiipImagineBundle/tree/1.9.1) (2017-09-09)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.9.0...1.9.1)

- __\[Console\]__ __\[BC BREAK\]__ The resolve command's --as-script/-s option/shortcut renamed to --machine-readable/-m \(fixes [\#988](https://github.com/liip/LiipImagineBundle/pull/988)\), its output updated to aligned with the resolve command, and the "--machine-readable/-m" option added.  [\#991](https://github.com/liip/LiipImagineBundle/pull/991) *([robfrawley](https://github.com/robfrawley))*

## [1.9.0](https://github.com/liip/LiipImagineBundle/tree/1.9.0) (2017-09-02)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.8.0...1.9.0)

- __\[Tests\]__ Fix filesystem loader deprecation message in tests. [\#982](https://github.com/liip/LiipImagineBundle/pull/982) *([robfrawley](https://github.com/robfrawley))*
- __\[Filter\]__ Add "centerright" and "centerleft" positions to background filter. [\#974](https://github.com/liip/LiipImagineBundle/pull/974) *([cmodijk](https://github.com/cmodijk))*
- __\[Config\]__ Allow to configure the HTTP response code for redirects. [\#970](https://github.com/liip/LiipImagineBundle/pull/970) *([lstrojny](https://github.com/lstrojny))*
- __\[Console\]__ Added --force option, renamed --filters to --filter, and made resolve command output pretty. [\#967](https://github.com/liip/LiipImagineBundle/pull/967) *([robfrawley](https://github.com/robfrawley))*
- __\[CS\]__ Fix two docblock annotations. [\#965](https://github.com/liip/LiipImagineBundle/pull/965) *([imanalopher](https://github.com/imanalopher))*
- __\[Data Loader\]__ __\[Deprecation\]__ The FileSystemLoader no longer accepts an array of data root paths; instead pass a FileSystemLocator, which should instead be passed said paths. [\#963](https://github.com/liip/LiipImagineBundle/pull/963/) *([robfrawley](https://github.com/robfrawley), [rpkamp](https://github.com/rpkamp))*
- __\[Composer\]__ Allow [avalanche123/Imagine](https://github.com/avalanche123/Imagine) version 0.7.0. [\#958](https://github.com/liip/LiipImagineBundle/pull/958) *([robfrawley](https://github.com/robfrawley))*
- __\[Data Loader\]__ __\[Documentation\]__ Add chain loader documentation. [\#957](https://github.com/liip/LiipImagineBundle/pull/957) *([robfrawley](https://github.com/robfrawley))*
- __\[Data Loader\]__ Add chain loader implementation. [\#953](https://github.com/liip/LiipImagineBundle/pull/953) *([robfrawley](https://github.com/robfrawley))*
- __\[CS\]__ Fix templating extension method return type. [\#951](https://github.com/liip/LiipImagineBundle/pull/951) *([imanalopher](https://github.com/imanalopher))*
- __\[Dependency Injection\]__ Fix compiler pass log message typo. [\#947](https://github.com/liip/LiipImagineBundle/pull/947) *([you-ser](https://github.com/you-ser))*
- __\[Travis\]__ Default to trusty container image \(with precise image for php 5.3\). [\#945](https://github.com/liip/LiipImagineBundle/pull/945) *([robfrawley](https://github.com/robfrawley))*
- __\[Enqueue\]__ Use simplified transport configuration. [\#942](https://github.com/liip/LiipImagineBundle/pull/942) *([makasim](https://github.com/makasim))*
- __\[Filter\]__ Add resolution loader implementation. [\#941](https://github.com/liip/LiipImagineBundle/pull/941) *([robfrawley](https://github.com/robfrawley))*
- __\[Travis\]__ Remove Symfony 3.3 from allowed failures. [\#940](https://github.com/liip/LiipImagineBundle/pull/940) *([robfrawley](https://github.com/robfrawley))*
- __\[Utility\]__ Use simplified Symfony kernel version comparison operation. [\#939](https://github.com/liip/LiipImagineBundle/pull/939) *([robfrawley](https://github.com/robfrawley))*

## [1.8.0](https://github.com/liip/LiipImagineBundle/tree/1.8.0) (2017-05-09)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.7.4...1.8.0)

- __\[Minor\]__ __\[Bug\]__ Revert to php-cs-fixer 1.x and run fixer [\#927](https://github.com/liip/LiipImagineBundle/pull/927) ([robfrawley](https://github.com/robfrawley))
- __\[Routing\]__ Deprecate XML routing file in favor of YAML [\#925](https://github.com/liip/LiipImagineBundle/pull/925) ([robfrawley](https://github.com/robfrawley))
- __\[Filter\]__ Add flip filter implementation to core [\#920](https://github.com/liip/LiipImagineBundle/pull/920) ([robfrawley](https://github.com/robfrawley))
- __\[Queue\]__ Resolve image caches in background using message queue. [\#919](https://github.com/liip/LiipImagineBundle/pull/919) ([makasim](https://github.com/makasim))

## [1.7.4](https://github.com/liip/LiipImagineBundle/tree/1.7.4) (2017-03-02)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.7.3...1.7.4)

- __\[Bug\]__ Revert adding leading slash to S3 class names [\#893](https://github.com/liip/LiipImagineBundle/pull/893) ([cedricziel](https://github.com/cedricziel))

## [1.7.3](https://github.com/liip/LiipImagineBundle/tree/1.7.3) (2017-03-02)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.7.2...1.7.3)

- __\[Tests\]__ Support PHPUnit 5.x (and remove depredations) [\#887](https://github.com/liip/LiipImagineBundle/pull/887) ([robfrawley](https://github.com/robfrawley))
- __\[Tests\]__ Assert expected deprecation using symfony/phpunit-bridge [\#886](https://github.com/liip/LiipImagineBundle/pull/886) ([robfrawley](https://github.com/robfrawley))
- __\[Minor\]__ __\[Docs\]__ Fix typo in general filters documentation [\#888](https://github.com/liip/LiipImagineBundle/pull/888) ([svenluijten](https://github.com/svenluijten))
- __\[Loader\]__ Add bundle resources to safe path when requested [\#883](https://github.com/liip/LiipImagineBundle/pull/883) ([bobvandevijver](https://github.com/bobvandevijver), [robfrawley](https://github.com/robfrawley))
- __\[Tests\]__ Enable mongo unit tests on PHP7 using "mongo" => "mongodb" extension adapter [\#882](https://github.com/liip/LiipImagineBundle/pull/882) ([robfrawley](https://github.com/robfrawley))
- __\[Loader\]__ __\[Locator\]__ FileSystemLocator service must not be shared [\#875](https://github.com/liip/LiipImagineBundle/pull/875) ([robfrawley](https://github.com/liip/LiipImagineBundle/pull/875))

## [1.7.2](https://github.com/liip/LiipImagineBundle/tree/1.7.2) (2017-02-07)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.7.1...1.7.2)

- __\[Loader\]__ Abstract filesystem resource locator and legacy insecure locator implementation [\#866](https://github.com/liip/LiipImagineBundle/pull/866) ([robfrawley](https://github.com/robfrawley))
- __\[Minor\]__ __\[Loader\]__ Fix for FileSystemLoader annotation [\#868](https://github.com/liip/LiipImagineBundle/pull/868) ([tgabi333](https://github.com/tgabi333))
- __\[DependencyInjection\]__ Container logging for compiler passes [\#867](https://github.com/liip/LiipImagineBundle/pull/867) ([robfrawley](https://github.com/robfrawley))
- __\[CI\]__ Use Prestissimo package for Travis build [\#864](https://github.com/liip/LiipImagineBundle/pull/864) ([robfrawley](https://github.com/robfrawley))
- __\[GitHub\]__ Add Hithub templates for issues and PRs [\#863](https://github.com/liip/LiipImagineBundle/pull/863) ([robfrawley](https://github.com/robfrawley))
- __\[Symfony\]__ Bug fixes and deprecation cleanup for Symfony 3.3 [\#860](https://github.com/liip/LiipImagineBundle/pull/860) ([robfrawley](https://github.com/robfrawley))
- __\[Filter\]__ Upscale filter should use the highest dimension to calculate ratio [\#856](https://github.com/liip/LiipImagineBundle/pull/856) ([Rattler3](https://github.com/Rattler3))

## [1.7.1](https://github.com/liip/LiipImagineBundle/tree/1.7.1) (2017-01-20)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.7.0...1.7.1)

- Allow multiple root paths for FileSystemLoader [\#851](https://github.com/liip/LiipImagineBundle/pull/851) ([robfrawley](https://github.com/robfrawley))
- Fix strange wording in readme [\#847](https://github.com/liip/LiipImagineBundle/pull/847) ([svenluijten](https://github.com/svenluijten))

## [1.7.0](https://github.com/liip/LiipImagineBundle/tree/1.7.0) (2017-01-08)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.6.0...1.7.0)

- Set DefaultMetadataReader when ext-exif is not present [\#841](https://github.com/liip/LiipImagineBundle/pull/841) ([cedricziel](https://github.com/cedricziel))
- Updating twig call to utilise asset\(\), to match README.md \(closes \#830\) [\#836](https://github.com/liip/LiipImagineBundle/pull/836) ([antoligy](https://github.com/antoligy))
- Exclude "Tests" directory from classmap [\#835](https://github.com/liip/LiipImagineBundle/pull/835) ([pamil](https://github.com/pamil))
- Require components that no longer ship with Symfony FrameworkBundle 3.2 [\#832](https://github.com/liip/LiipImagineBundle/pull/832) ([rpkamp](https://github.com/rpkamp))
- Document how web paths are built [\#829](https://github.com/liip/LiipImagineBundle/pull/829) ([greg0ire](https://github.com/greg0ire))
- Wrap relative path with asset\(\) Twig function [\#825](https://github.com/liip/LiipImagineBundle/pull/825) ([bocharsky-bw](https://github.com/bocharsky-bw))
- Update data-loaders.rst [\#821](https://github.com/liip/LiipImagineBundle/pull/821) ([IllesAprod](https://github.com/IllesAprod))
- Updating 2.0 with corrections from 1.0 [\#820](https://github.com/liip/LiipImagineBundle/pull/820) ([antoligy](https://github.com/antoligy))
- Typo fix [\#819](https://github.com/liip/LiipImagineBundle/pull/819) ([redjanym](https://github.com/redjanym))
- Fix RST indentation error in AWS S3 cache resolver documentation [\#809](https://github.com/liip/LiipImagineBundle/pull/809) ([GeoffreyHervet](https://github.com/GeoffreyHervet))
- Update basic-usage.rst [\#805](https://github.com/liip/LiipImagineBundle/pull/805) ([you-ser](https://github.com/you-ser))
- Add data\_loader config to doc [\#803](https://github.com/liip/LiipImagineBundle/pull/803) ([davidfuhr](https://github.com/davidfuhr))
- RST Typo Fix and Clarification for Watermark Docs [\#802](https://github.com/liip/LiipImagineBundle/pull/802) ([robfrawley](https://github.com/robfrawley))
- Update Source to Newly Merged Style Rule Additions [\#800](https://github.com/liip/LiipImagineBundle/pull/800) ([robfrawley](https://github.com/robfrawley))
- Bugfix: Remove Short Array Syntax and Fix \(Minor\) Recent Merge Issues [\#799](https://github.com/liip/LiipImagineBundle/pull/799) ([robfrawley](https://github.com/robfrawley))
- Add Symfony Framework 3.1.x and 3.2-dev to build matrix [\#796](https://github.com/liip/LiipImagineBundle/pull/796) ([cedricziel](https://github.com/cedricziel))
- Add visibility argument to service definition [\#795](https://github.com/liip/LiipImagineBundle/pull/795) ([cedricziel](https://github.com/cedricziel))
- Bugfix for Failing Tests Introduced in \#777 [\#793](https://github.com/liip/LiipImagineBundle/pull/793) ([robfrawley](https://github.com/robfrawley))
- Added php\_cs.dist / Updated .styleci.yml / Fixed and updated .travis.yml [\#792](https://github.com/liip/LiipImagineBundle/pull/792) ([robfrawley](https://github.com/robfrawley))
- Add LICENSE.md [\#790](https://github.com/liip/LiipImagineBundle/pull/790) ([robfrawley](https://github.com/robfrawley))
- Updated README.md and RST Documentation [\#789](https://github.com/liip/LiipImagineBundle/pull/789) ([robfrawley](https://github.com/robfrawley))
- Updated CHANGELOG.md [\#788](https://github.com/liip/LiipImagineBundle/pull/788) ([robfrawley](https://github.com/robfrawley))
- List deprecation - closes \#731 [\#787](https://github.com/liip/LiipImagineBundle/pull/787) ([antoligy](https://github.com/antoligy))
- Cleanup FileSystemLoader \(Followup to \#775\) [\#785](https://github.com/liip/LiipImagineBundle/pull/785) ([robfrawley](https://github.com/robfrawley))
- Tempdir for postprocessors [\#779](https://github.com/liip/LiipImagineBundle/pull/779) ([jehaby](https://github.com/jehaby))
- Add visibility argument to flysystem resolver [\#777](https://github.com/liip/LiipImagineBundle/pull/777) ([cedricziel](https://github.com/cedricziel))
- Amend path resolution handlers and outside root check conditional in FileSystemLoader [\#775](https://github.com/liip/LiipImagineBundle/pull/775) ([robfrawley](https://github.com/robfrawley))
- Scale filter and Downscale and Upscale as derivatives, with a new feature [\#773](https://github.com/liip/LiipImagineBundle/pull/773) ([deviprsd21](https://github.com/deviprsd21))
- Applied fixes from StyleCI [\#768](https://github.com/liip/LiipImagineBundle/pull/768) ([lsmith77](https://github.com/lsmith77))
- Replaced deprecated factory\_class and factory\_method [\#767](https://github.com/liip/LiipImagineBundle/pull/767) ([rvanlaarhoven](https://github.com/rvanlaarhoven))
- Update basic-usage.rst [\#766](https://github.com/liip/LiipImagineBundle/pull/766) ([nochecksum](https://github.com/nochecksum))
- Implemented ConfigurablePostProcessorInterface in OptiPngPostProcessor [\#764](https://github.com/liip/LiipImagineBundle/pull/764) ([jehaby](https://github.com/jehaby))

## [1.6.0](https://github.com/liip/LiipImagineBundle/tree/1.6.0) (2016-07-22)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.5.3...1.6.0)

- Input is added twice in the OptiPngProcessor. [\#762](https://github.com/liip/LiipImagineBundle/pull/762) ([antoligy](https://github.com/antoligy))
- Enable configuration of post processors using parameters \(closes \#720\) [\#759](https://github.com/liip/LiipImagineBundle/pull/759) ([antoligy](https://github.com/antoligy))
- Applied fixes from StyleCI [\#758](https://github.com/liip/LiipImagineBundle/pull/758) ([lsmith77](https://github.com/lsmith77))
- Applied fixes from StyleCI [\#757](https://github.com/liip/LiipImagineBundle/pull/757) ([lsmith77](https://github.com/lsmith77))
- Add configuration options for jpegoptim post-processor [\#756](https://github.com/liip/LiipImagineBundle/pull/756) ([dylanschoenmakers](https://github.com/dylanschoenmakers))
- Ignore invalid exif orientations [\#751](https://github.com/liip/LiipImagineBundle/pull/751) ([lstrojny](https://github.com/lstrojny))
- Quote strings starting '%' in YAML [\#745](https://github.com/liip/LiipImagineBundle/pull/745) ([jaikdean](https://github.com/jaikdean))
- Fix tempnam usages [\#723](https://github.com/liip/LiipImagineBundle/pull/723) ([1ed](https://github.com/1ed))
- background filter: allow image positioning [\#721](https://github.com/liip/LiipImagineBundle/pull/721) ([uvoelkel](https://github.com/uvoelkel))
- Add Flysystem resolver [\#715](https://github.com/liip/LiipImagineBundle/pull/715) ([cedricziel](https://github.com/cedricziel))
- Downscale filter scales an image to fit bounding box [\#696](https://github.com/liip/LiipImagineBundle/pull/696) ([aminin](https://github.com/aminin))
- Implement Imagine Grayscale filter [\#638](https://github.com/liip/LiipImagineBundle/pull/638) ([gregumo](https://github.com/gregumo))

## [1.5.3](https://github.com/liip/LiipImagineBundle/tree/1.5.3) (2016-05-06)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.5.2...1.5.3)

- add @Event annotation to let IDEs known event names and class instance [\#732](https://github.com/liip/LiipImagineBundle/pull/732) ([Haehnchen](https://github.com/Haehnchen))
- Introduce mozjpeg and pngquant post-processors, add transform options. [\#717](https://github.com/liip/LiipImagineBundle/pull/717) ([antoligy](https://github.com/antoligy))
- StreamLoader-exception-arguments [\#714](https://github.com/liip/LiipImagineBundle/pull/714) ([antonsmolin](https://github.com/antonsmolin))

## [1.5.2](https://github.com/liip/LiipImagineBundle/tree/1.5.2) (2016-02-16)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.5.1...1.5.2)

- Revert "Merge pull request \#699 from jockri/fix-background-filter" [\#709](https://github.com/liip/LiipImagineBundle/pull/709) ([mangelsnc](https://github.com/mangelsnc))

## [1.5.1](https://github.com/liip/LiipImagineBundle/tree/1.5.1) (2016-02-13)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.5.0...1.5.1)

- Fix regression introduced in bb8e4109672902e37931e0a491ff55ebac93d8e9 [\#707](https://github.com/liip/LiipImagineBundle/pull/707) ([Seldaek](https://github.com/Seldaek))

## [1.5.0](https://github.com/liip/LiipImagineBundle/tree/1.5.0) (2016-02-12)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.4.3...1.5.0)

- Applied fixes from StyleCI [\#706](https://github.com/liip/LiipImagineBundle/pull/706) ([lsmith77](https://github.com/lsmith77))
- Add FileBinary\[Interface\] to support large files without loading them in memory unnecessarily [\#705](https://github.com/liip/LiipImagineBundle/pull/705) ([Seldaek](https://github.com/Seldaek))
- Fix background filter [\#699](https://github.com/liip/LiipImagineBundle/pull/699) ([jockri](https://github.com/jockri))
- Fix undeclared variable [\#697](https://github.com/liip/LiipImagineBundle/pull/697) ([tifabien](https://github.com/tifabien))
- Update WebPathResolver.php [\#695](https://github.com/liip/LiipImagineBundle/pull/695) ([gonzalovilaseca](https://github.com/gonzalovilaseca))
- Add missing link to the filters doc [\#694](https://github.com/liip/LiipImagineBundle/pull/694) ([bocharsky-bw](https://github.com/bocharsky-bw))
- Adding optipng post transformer [\#692](https://github.com/liip/LiipImagineBundle/pull/692) ([gouaille](https://github.com/gouaille))

## [1.4.3](https://github.com/liip/LiipImagineBundle/tree/1.4.3) (2016-01-14)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.4.2...1.4.3)

- Fixed build issues [\#691](https://github.com/liip/LiipImagineBundle/pull/691) ([yceruto](https://github.com/yceruto))
- Fixed doc errors reported by docs build tool [\#690](https://github.com/liip/LiipImagineBundle/pull/690) ([javiereguiluz](https://github.com/javiereguiluz))
- Explicit attr definition was added [\#688](https://github.com/liip/LiipImagineBundle/pull/688) ([ostretsov](https://github.com/ostretsov))
- Flysystem support added. [\#674](https://github.com/liip/LiipImagineBundle/pull/674) ([graundas](https://github.com/graundas))

## [1.4.2](https://github.com/liip/LiipImagineBundle/tree/1.4.2) (2015-12-29)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.4.1...1.4.2)

- Proxy resolver allow find and replace and regexp strategies [\#687](https://github.com/liip/LiipImagineBundle/pull/687) ([makasim](https://github.com/makasim))
- added contributing docs [\#681](https://github.com/liip/LiipImagineBundle/pull/681) ([helios-ag](https://github.com/helios-ag))
- rebased commands document patch, see \#533 [\#680](https://github.com/liip/LiipImagineBundle/pull/680) ([helios-ag](https://github.com/helios-ag))

## [1.4.1](https://github.com/liip/LiipImagineBundle/tree/1.4.1) (2015-12-27)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.4.0...1.4.1)

- Aws sdk v3 [\#685](https://github.com/liip/LiipImagineBundle/pull/685) ([makasim](https://github.com/makasim))

## [1.4.0](https://github.com/liip/LiipImagineBundle/tree/1.4.0) (2015-12-27)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.3.3...1.4.0)

- __\[resolver\]__ Add ability to force resolver. [\#684](https://github.com/liip/LiipImagineBundle/pull/684) ([makasim](https://github.com/makasim))

## [1.3.3](https://github.com/liip/LiipImagineBundle/tree/1.3.3) (2015-12-27)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.3.2...1.3.3)

- Destruct image to cleanup memory [\#682](https://github.com/liip/LiipImagineBundle/pull/682) ([cmodijk](https://github.com/cmodijk))

## [1.3.2](https://github.com/liip/LiipImagineBundle/tree/1.3.2) (2015-12-10)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.3.1...1.3.2)

- Removed UrlGenerator deprecations from symfony 2.8 [\#673](https://github.com/liip/LiipImagineBundle/pull/673) ([sebastianblum](https://github.com/sebastianblum))
- Typo [\#668](https://github.com/liip/LiipImagineBundle/pull/668) ([benoitMariaux](https://github.com/benoitMariaux))
- Misc. fixes and improvements to the docs [\#667](https://github.com/liip/LiipImagineBundle/pull/667) ([javiereguiluz](https://github.com/javiereguiluz))
- skip MongoDB ODM related tests on PHP7 and HHVM [\#659](https://github.com/liip/LiipImagineBundle/pull/659) ([lsmith77](https://github.com/lsmith77))
- Fix all test fails in master \(just to check\) [\#658](https://github.com/liip/LiipImagineBundle/pull/658) ([kamazee](https://github.com/kamazee))
- Fix handling invalid orientation in AutoRotateFilterLoader & test exceptions [\#657](https://github.com/liip/LiipImagineBundle/pull/657) ([kamazee](https://github.com/kamazee))
- Fix broken CacheResolver tests \(\#650\) [\#655](https://github.com/liip/LiipImagineBundle/pull/655) ([kamazee](https://github.com/kamazee))
- - Task: correctly handles all rotations, even those involving flippin… [\#654](https://github.com/liip/LiipImagineBundle/pull/654) ([Heshyo](https://github.com/Heshyo))
- Incorporate feedback from @WouterJ for PR 651 [\#653](https://github.com/liip/LiipImagineBundle/pull/653) ([kix](https://github.com/kix))
- Applied fixes from StyleCI [\#652](https://github.com/liip/LiipImagineBundle/pull/652) ([lsmith77](https://github.com/lsmith77))
- Add notes on basic usage [\#651](https://github.com/liip/LiipImagineBundle/pull/651) ([kix](https://github.com/kix))
- Fix travis php version [\#649](https://github.com/liip/LiipImagineBundle/pull/649) ([Koc](https://github.com/Koc))
- Update StreamLoader.php [\#648](https://github.com/liip/LiipImagineBundle/pull/648) ([kix](https://github.com/kix))
- Applied fixes from StyleCI [\#646](https://github.com/liip/LiipImagineBundle/pull/646) ([lsmith77](https://github.com/lsmith77))
- updated build matrix [\#645](https://github.com/liip/LiipImagineBundle/pull/645) ([lsmith77](https://github.com/lsmith77))
- Fix typo [\#634](https://github.com/liip/LiipImagineBundle/pull/634) ([trsteel88](https://github.com/trsteel88))
- Added support for special characters and white spaces in image name [\#629](https://github.com/liip/LiipImagineBundle/pull/629) ([ivanbarlog](https://github.com/ivanbarlog))
- Updated docs for features introduced in Symfony 2.4 [\#621](https://github.com/liip/LiipImagineBundle/pull/621) ([foaly-nr1](https://github.com/foaly-nr1))
- Use identity instead equality [\#619](https://github.com/liip/LiipImagineBundle/pull/619) ([piotrantosik](https://github.com/piotrantosik))
- context parameter cannot be an empty string [\#618](https://github.com/liip/LiipImagineBundle/pull/618) ([aistis-](https://github.com/aistis-))
- introduced DownscaleFilterLoader [\#610](https://github.com/liip/LiipImagineBundle/pull/610) ([sascha-meissner](https://github.com/sascha-meissner))

## [1.3.1](https://github.com/liip/LiipImagineBundle/tree/1.3.1) (2015-08-27)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.3.0...1.3.1)

- Fix deprecated twig filter syntax [\#631](https://github.com/liip/LiipImagineBundle/pull/631) ([jrattue](https://github.com/jrattue))
- fix invalid yaml [\#623](https://github.com/liip/LiipImagineBundle/pull/623) ([carlcraig](https://github.com/carlcraig))
- switch to docker based travis infrastructure [\#622](https://github.com/liip/LiipImagineBundle/pull/622) ([lsmith77](https://github.com/lsmith77))
- Return string, not Twig\_Markup object in Twig extension [\#615](https://github.com/liip/LiipImagineBundle/pull/615) ([lstrojny](https://github.com/lstrojny))
- Use is\_file\(\) instead of Filesystem::exists\(\) [\#614](https://github.com/liip/LiipImagineBundle/pull/614) ([lstrojny](https://github.com/lstrojny))
- Make it easier to get a dev environment up and running [\#613](https://github.com/liip/LiipImagineBundle/pull/613) ([lstrojny](https://github.com/lstrojny))
- Fix code block into README [\#608](https://github.com/liip/LiipImagineBundle/pull/608) ([PedroTroller](https://github.com/PedroTroller))
- fix upscale size not being calculated correctly [\#561](https://github.com/liip/LiipImagineBundle/pull/561) ([scuben](https://github.com/scuben))

## [1.3.0](https://github.com/liip/LiipImagineBundle/tree/1.3.0) (2015-06-04)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.7...1.3.0)

- use setFactory service definition method for symfony \>= 2.6 \(when possible\) [\#566](https://github.com/liip/LiipImagineBundle/pull/566) ([adam187](https://github.com/adam187))

## [1.2.7](https://github.com/liip/LiipImagineBundle/tree/1.2.7) (2015-06-02)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.6...1.2.7)

- Make AwsS3Resolver compatible with SDK v3 [\#605](https://github.com/liip/LiipImagineBundle/pull/605) ([cdaguerre](https://github.com/cdaguerre))
- __\[Doc\]__ Add missing coma and fix indentation in README.md [\#604](https://github.com/liip/LiipImagineBundle/pull/604) ([grena](https://github.com/grena))
- Removed TransformerInterface [\#603](https://github.com/liip/LiipImagineBundle/pull/603) ([rvanlaarhoven](https://github.com/rvanlaarhoven))
- remove duplicate parameter [\#601](https://github.com/liip/LiipImagineBundle/pull/601) ([ip512](https://github.com/ip512))
- Fix typo [\#600](https://github.com/liip/LiipImagineBundle/pull/600) ([hpatoio](https://github.com/hpatoio))
- Adding details to use the bundle with remote images [\#569](https://github.com/liip/LiipImagineBundle/pull/569) ([flug](https://github.com/flug))

## [1.2.6](https://github.com/liip/LiipImagineBundle/tree/1.2.6) (2015-04-24)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.5...1.2.6)

- Check $filters is an array [\#596](https://github.com/liip/LiipImagineBundle/pull/596) ([trsteel88](https://github.com/trsteel88))

## [1.2.5](https://github.com/liip/LiipImagineBundle/tree/1.2.5) (2015-04-08)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.4...1.2.5)

- Add image rotate filter [\#588](https://github.com/liip/LiipImagineBundle/pull/588) ([bocharsky-bw](https://github.com/bocharsky-bw))
- run php-cs-fixer on bundle [\#583](https://github.com/liip/LiipImagineBundle/pull/583) ([trsteel88](https://github.com/trsteel88))
- Fix typo [\#582](https://github.com/liip/LiipImagineBundle/pull/582) ([bicpi](https://github.com/bicpi))
- Fix typos [\#581](https://github.com/liip/LiipImagineBundle/pull/581) ([bicpi](https://github.com/bicpi))
- Fix typos [\#580](https://github.com/liip/LiipImagineBundle/pull/580) ([bicpi](https://github.com/bicpi))

## [1.2.4](https://github.com/liip/LiipImagineBundle/tree/1.2.4) (2015-03-27)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.3...1.2.4)

- Update how missing filters are logged [\#579](https://github.com/liip/LiipImagineBundle/pull/579) ([trsteel88](https://github.com/trsteel88))
- use isDefined method for OptionsResolver instead of isKnown  \(when possible\) [\#567](https://github.com/liip/LiipImagineBundle/pull/567) ([adam187](https://github.com/adam187))

## [1.2.3](https://github.com/liip/LiipImagineBundle/tree/1.2.3) (2015-02-22)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.2...1.2.3)

- fix invalid in\_array [\#565](https://github.com/liip/LiipImagineBundle/pull/565) ([digitalkaoz](https://github.com/digitalkaoz))
- Add a short introductory paragraph about the bundle [\#559](https://github.com/liip/LiipImagineBundle/pull/559) ([javiereguiluz](https://github.com/javiereguiluz))
- Update Filters.rst [\#556](https://github.com/liip/LiipImagineBundle/pull/556) ([Spawnrad](https://github.com/Spawnrad))
- Fixed the syntax of the internal doc links [\#554](https://github.com/liip/LiipImagineBundle/pull/554) ([javiereguiluz](https://github.com/javiereguiluz))
- Updated README.md to point to new .rst doc files [\#551](https://github.com/liip/LiipImagineBundle/pull/551) ([Khez](https://github.com/Khez))
- fix typo on readme file [\#550](https://github.com/liip/LiipImagineBundle/pull/550) ([erivello](https://github.com/erivello))
- Switched the documentation from Markdown to ReStructuredText [\#545](https://github.com/liip/LiipImagineBundle/pull/545) ([javiereguiluz](https://github.com/javiereguiluz))
- Fix Filter Documentation [\#544](https://github.com/liip/LiipImagineBundle/pull/544) ([wodka](https://github.com/wodka))
- Add support for the new quality options [\#473](https://github.com/liip/LiipImagineBundle/pull/473) ([patrickli](https://github.com/patrickli))

## [1.2.2](https://github.com/liip/LiipImagineBundle/tree/1.2.2) (2015-01-08)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.1...1.2.2)

- Update the filter\_sets Documentation about removed configurations [\#543](https://github.com/liip/LiipImagineBundle/pull/543) ([mbiagetti](https://github.com/mbiagetti))
- implement interlace filter [\#503](https://github.com/liip/LiipImagineBundle/pull/503) ([wodka](https://github.com/wodka))

## [1.2.1](https://github.com/liip/LiipImagineBundle/tree/1.2.1) (2014-12-10)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.2.0...1.2.1)

- argument to s3 resolver prototype definition has been added [\#536](https://github.com/liip/LiipImagineBundle/pull/536) ([ruslan-polutsygan](https://github.com/ruslan-polutsygan))

## [1.2.0](https://github.com/liip/LiipImagineBundle/tree/1.2.0) (2014-12-10)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.1.1...1.2.0)

- S3 resolver put options [\#535](https://github.com/liip/LiipImagineBundle/pull/535) ([ruslan-polutsygan](https://github.com/ruslan-polutsygan))
- Fixed minor PHPDoc [\#528](https://github.com/liip/LiipImagineBundle/pull/528) ([sdaoudi](https://github.com/sdaoudi))

## [1.1.1](https://github.com/liip/LiipImagineBundle/tree/1.1.1) (2014-11-12)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.1.0...1.1.1)

- Fix crash when no post processor is defined [\#526](https://github.com/liip/LiipImagineBundle/pull/526) ([lolautruche](https://github.com/lolautruche))
- WebPathResolver - sanitize URL to directory name [\#480](https://github.com/liip/LiipImagineBundle/pull/480) ([teohhanhui](https://github.com/teohhanhui))

## [1.1.0](https://github.com/liip/LiipImagineBundle/tree/1.1.0) (2014-10-29)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.8...1.1.0)

- Post-processors - handlers to be applied on filtered image binary [\#519](https://github.com/liip/LiipImagineBundle/pull/519) ([kostiklv](https://github.com/kostiklv))

## [1.0.8](https://github.com/liip/LiipImagineBundle/tree/1.0.8) (2014-10-22)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.7...1.0.8)

- Delete АГГЗ.jpeg [\#515](https://github.com/liip/LiipImagineBundle/pull/515) ([ndoulgeridis](https://github.com/ndoulgeridis))
- Update configuration.md [\#513](https://github.com/liip/LiipImagineBundle/pull/513) ([hugohenrique](https://github.com/hugohenrique))

## [1.0.7](https://github.com/liip/LiipImagineBundle/tree/1.0.7) (2014-10-18)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.6...1.0.7)

- fix tests, upgrade phpunit up to 4.3 [\#511](https://github.com/liip/LiipImagineBundle/pull/511) ([makasim](https://github.com/makasim))
- Image default when notloadable exception [\#510](https://github.com/liip/LiipImagineBundle/pull/510) ([Neime](https://github.com/Neime))
- Explain how to change the default resolver [\#508](https://github.com/liip/LiipImagineBundle/pull/508) ([dbu](https://github.com/dbu))
- Updated DI configuration to the current implementation of the loader [\#500](https://github.com/liip/LiipImagineBundle/pull/500) ([peterrehm](https://github.com/peterrehm))
- Support custom output format for each filter set [\#477](https://github.com/liip/LiipImagineBundle/pull/477) ([teohhanhui](https://github.com/teohhanhui))

## [1.0.6](https://github.com/liip/LiipImagineBundle/tree/1.0.6) (2014-09-17)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.5...1.0.6)

- Fix GridFSLoader [\#461](https://github.com/liip/LiipImagineBundle/pull/461) ([aldeck](https://github.com/aldeck))

## [1.0.5](https://github.com/liip/LiipImagineBundle/tree/1.0.5) (2014-09-15)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.4...1.0.5)

- check if runtimeconfig path is stored [\#498](https://github.com/liip/LiipImagineBundle/pull/498) ([trsteel88](https://github.com/trsteel88))
- Update README.md [\#490](https://github.com/liip/LiipImagineBundle/pull/490) ([JellyBellyDev](https://github.com/JellyBellyDev))
- Update README.md [\#488](https://github.com/liip/LiipImagineBundle/pull/488) ([JellyBellyDev](https://github.com/JellyBellyDev))
- fix auto rotate [\#476](https://github.com/liip/LiipImagineBundle/pull/476) ([scuben](https://github.com/scuben))
- support animated gif [\#466](https://github.com/liip/LiipImagineBundle/pull/466) ([scuben](https://github.com/scuben))

## [1.0.4](https://github.com/liip/LiipImagineBundle/tree/1.0.4) (2014-07-30)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.3...1.0.4)

- Update WebPathResolverFactory.php [\#467](https://github.com/liip/LiipImagineBundle/pull/467) ([JJK801](https://github.com/JJK801))

## [1.0.3](https://github.com/liip/LiipImagineBundle/tree/1.0.3) (2014-07-30)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.2...1.0.3)

- Fixing issue with removed class Color [\#458](https://github.com/liip/LiipImagineBundle/pull/458) ([lstrojny](https://github.com/lstrojny))
- Added PHP 5.6 and HHVM to travis.yml [\#454](https://github.com/liip/LiipImagineBundle/pull/454) ([Nyholm](https://github.com/Nyholm))
- make the Bundle compatible with config:dump-reference command [\#452](https://github.com/liip/LiipImagineBundle/pull/452) ([lsmith77](https://github.com/lsmith77))

## [1.0.2](https://github.com/liip/LiipImagineBundle/tree/1.0.2) (2014-06-24)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.1...1.0.2)

- Update README.md [\#447](https://github.com/liip/LiipImagineBundle/pull/447) ([sgaze](https://github.com/sgaze))
- Update configuration.md [\#446](https://github.com/liip/LiipImagineBundle/pull/446) ([sgaze](https://github.com/sgaze))

## [1.0.1](https://github.com/liip/LiipImagineBundle/tree/1.0.1) (2014-06-06)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0...1.0.1)

- __\[stream\]__ throws exception when content cannot be read. [\#444](https://github.com/liip/LiipImagineBundle/pull/444) ([makasim](https://github.com/makasim))
- remove unused use-statement and fix phpdoc [\#441](https://github.com/liip/LiipImagineBundle/pull/441) ([UFOMelkor](https://github.com/UFOMelkor))

## [1.0.0](https://github.com/liip/LiipImagineBundle/tree/1.0.0) (2014-05-22)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha7...1.0.0)

- added possibility to use imagine new metadata api [\#413](https://github.com/liip/LiipImagineBundle/pull/413) ([digitalkaoz](https://github.com/digitalkaoz))

## [1.0.0-alpha7](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha7) (2014-05-22)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha6...1.0.0-alpha7)

## [1.0.0-alpha6](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha6) (2014-05-05)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha5...1.0.0-alpha6)

- __\[router\]__ remove custom route loader. [\#425](https://github.com/liip/LiipImagineBundle/pull/425) ([makasim](https://github.com/makasim))

## [1.0.0-alpha5](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha5) (2014-04-29)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha4...1.0.0-alpha5)

- added scrutinizer config [\#420](https://github.com/liip/LiipImagineBundle/pull/420) ([digitalkaoz](https://github.com/digitalkaoz))
- Fixed testsuite \#417 in \#403 [\#419](https://github.com/liip/LiipImagineBundle/pull/419) ([ama3ing](https://github.com/ama3ing))
- increase test coverage report [\#417](https://github.com/liip/LiipImagineBundle/pull/417) ([digitalkaoz](https://github.com/digitalkaoz))
- enabled symfony 2.4 on travis [\#416](https://github.com/liip/LiipImagineBundle/pull/416) ([digitalkaoz](https://github.com/digitalkaoz))
- Update configuration.md [\#410](https://github.com/liip/LiipImagineBundle/pull/410) ([ama3ing](https://github.com/ama3ing))
- __\[ci\]__ run tests only on 2.3 version. [\#407](https://github.com/liip/LiipImagineBundle/pull/407) ([makasim](https://github.com/makasim))
- Watermark filter documentation update. Fixes \#404 [\#406](https://github.com/liip/LiipImagineBundle/pull/406) ([ama3ing](https://github.com/ama3ing))
- Fixes \#373. Replace NotFoundHttpException with SourceNotFoundException [\#403](https://github.com/liip/LiipImagineBundle/pull/403) ([ama3ing](https://github.com/ama3ing))
- Removed unreachable statement [\#402](https://github.com/liip/LiipImagineBundle/pull/402) ([ama3ing](https://github.com/ama3ing))
- Fix of \#369 \(Trim of forwarding slash in path\) [\#401](https://github.com/liip/LiipImagineBundle/pull/401) ([ama3ing](https://github.com/ama3ing))

## [1.0.0-alpha4](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha4) (2014-04-14)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha3...1.0.0-alpha4)

- __\[config\]__ correctly process resolvers\loaders section if not array or null [\#396](https://github.com/liip/LiipImagineBundle/pull/396) ([makasim](https://github.com/makasim))
- Issue\#368 wrong image path [\#395](https://github.com/liip/LiipImagineBundle/pull/395) ([serdyuka](https://github.com/serdyuka))

## [1.0.0-alpha3](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha3) (2014-04-14)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha2...1.0.0-alpha3)

- Added proxy to aws s3 resolver factory [\#392](https://github.com/liip/LiipImagineBundle/pull/392) ([serdyuka](https://github.com/serdyuka))

## [1.0.0-alpha2](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha2) (2014-04-10)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/1.0.0-alpha1...1.0.0-alpha2)

- Documentation update fixes \#389 [\#390](https://github.com/liip/LiipImagineBundle/pull/390) ([ama3ing](https://github.com/ama3ing))
- Added resolve events to cache manager [\#388](https://github.com/liip/LiipImagineBundle/pull/388) ([serdyuka](https://github.com/serdyuka))

## [1.0.0-alpha1](https://github.com/liip/LiipImagineBundle/tree/1.0.0-alpha1) (2014-04-07)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.21.1...1.0.0-alpha1)

- Remove cli command [\#387](https://github.com/liip/LiipImagineBundle/pull/387) ([serdyuka](https://github.com/serdyuka))
- fixed and improved tests for resolve cache command [\#386](https://github.com/liip/LiipImagineBundle/pull/386) ([serdyuka](https://github.com/serdyuka))
- __\[1.0\]__\[config\] Fix default loader not found bug. [\#385](https://github.com/liip/LiipImagineBundle/pull/385) ([makasim](https://github.com/makasim))
- Resolve command few paths [\#383](https://github.com/liip/LiipImagineBundle/pull/383) ([serdyuka](https://github.com/serdyuka))
- Move data loaders to binary folder [\#382](https://github.com/liip/LiipImagineBundle/pull/382) ([serdyuka](https://github.com/serdyuka))
- Documentation for cli command [\#380](https://github.com/liip/LiipImagineBundle/pull/380) ([serdyuka](https://github.com/serdyuka))
- Cli command to resolve cache [\#379](https://github.com/liip/LiipImagineBundle/pull/379) ([serdyuka](https://github.com/serdyuka))
- Update README.md [\#374](https://github.com/liip/LiipImagineBundle/pull/374) ([daslicht](https://github.com/daslicht))
- __\[1.0\]__\[loader\] cleanup filesystem loader, simplify logic, add factory. [\#371](https://github.com/liip/LiipImagineBundle/pull/371) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[aws-resolver\] allow configure cache\_prefix via factory. [\#370](https://github.com/liip/LiipImagineBundle/pull/370) ([makasim](https://github.com/makasim))
- __\[1.0\]__ set web\_path resolver as default if not configured. [\#367](https://github.com/liip/LiipImagineBundle/pull/367) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[Config\] remove path option. [\#366](https://github.com/liip/LiipImagineBundle/pull/366) ([makasim](https://github.com/makasim))
- Fixed yaml code block on stream loader documentation [\#363](https://github.com/liip/LiipImagineBundle/pull/363) ([rvanlaarhoven](https://github.com/rvanlaarhoven))
- __\[1.0\]__\[WebResolver\] Use baseUrl and port while generating image path. [\#362](https://github.com/liip/LiipImagineBundle/pull/362) ([makasim](https://github.com/makasim))
- Removed cache\_clearer documentation [\#359](https://github.com/liip/LiipImagineBundle/pull/359) ([rvanlaarhoven](https://github.com/rvanlaarhoven))
- CacheManager updated [\#355](https://github.com/liip/LiipImagineBundle/pull/355) ([ossinkine](https://github.com/ossinkine))
- FilesystemLoader updated [\#354](https://github.com/liip/LiipImagineBundle/pull/354) ([ossinkine](https://github.com/ossinkine))
- Update filters.md [\#346](https://github.com/liip/LiipImagineBundle/pull/346) ([zazoomauro](https://github.com/zazoomauro))

## [v0.21.1](https://github.com/liip/LiipImagineBundle/tree/v0.21.1) (2014-03-14)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.21.0...v0.21.1)

## [v0.21.0](https://github.com/liip/LiipImagineBundle/tree/v0.21.0) (2014-03-14)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.20.2...v0.21.0)

- Added reference on how to get image path inside a controller [\#340](https://github.com/liip/LiipImagineBundle/pull/340) ([ama3ing](https://github.com/ama3ing))
- __\[1.0\]__ add phpunit as require-dev [\#339](https://github.com/liip/LiipImagineBundle/pull/339) ([makasim](https://github.com/makasim))
- __\[1.0\]__ Twig helper not escape filter url [\#337](https://github.com/liip/LiipImagineBundle/pull/337) ([makasim](https://github.com/makasim))
- Added cache clearing & setting cachePrefix for Aws S3 [\#336](https://github.com/liip/LiipImagineBundle/pull/336) ([rvanlaarhoven](https://github.com/rvanlaarhoven))
- Merge latest changes in master to develop branch  [\#334](https://github.com/liip/LiipImagineBundle/pull/334) ([makasim](https://github.com/makasim))
- Update to Imagine 0.6 [\#330](https://github.com/liip/LiipImagineBundle/pull/330) ([vlastv](https://github.com/vlastv))
- __\[1.0\]__\[Configuration\] Cleanup bundle configuration. [\#325](https://github.com/liip/LiipImagineBundle/pull/325) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[filter\] Dynamic filters [\#313](https://github.com/liip/LiipImagineBundle/pull/313) ([makasim](https://github.com/makasim))

## [v0.20.2](https://github.com/liip/LiipImagineBundle/tree/v0.20.2) (2014-02-20)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.20.1...v0.20.2)

- GridFSLoader Bug [\#331](https://github.com/liip/LiipImagineBundle/pull/331) ([peterrehm](https://github.com/peterrehm))
- Update filters.md [\#327](https://github.com/liip/LiipImagineBundle/pull/327) ([herb123456](https://github.com/herb123456))

## [v0.20.1](https://github.com/liip/LiipImagineBundle/tree/v0.20.1) (2014-02-10)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.20.0...v0.20.1)

- fixed ProxyResolver-\>getBrowserPath [\#323](https://github.com/liip/LiipImagineBundle/pull/323) ([digitalkaoz](https://github.com/digitalkaoz))

## [v0.20.0](https://github.com/liip/LiipImagineBundle/tree/v0.20.0) (2014-02-07)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.19.0...v0.20.0)

- __\[1.0\]__\[resolver\] Decouple WebPathResolver from http request. Simplify its logic. [\#320](https://github.com/liip/LiipImagineBundle/pull/320) ([makasim](https://github.com/makasim))
- added proxy cache resolver [\#318](https://github.com/liip/LiipImagineBundle/pull/318) ([digitalkaoz](https://github.com/digitalkaoz))

## [v0.19.0](https://github.com/liip/LiipImagineBundle/tree/v0.19.0) (2014-02-07)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.18.0...v0.19.0)

- improved exception on generation failure [\#321](https://github.com/liip/LiipImagineBundle/pull/321) ([digitalkaoz](https://github.com/digitalkaoz))
- __\[1.0\]__ Fix tests on current develop branch [\#316](https://github.com/liip/LiipImagineBundle/pull/316) ([makasim](https://github.com/makasim))

## [v0.18.0](https://github.com/liip/LiipImagineBundle/tree/v0.18.0) (2014-01-29)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.17.1...v0.18.0)

- added an "auto\_rotate" filter based on exif data [\#254](https://github.com/liip/LiipImagineBundle/pull/254) ([digitalkaoz](https://github.com/digitalkaoz))

## [v0.17.1](https://github.com/liip/LiipImagineBundle/tree/v0.17.1) (2014-01-24)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.17.0...v0.17.1)

- fixed missing namespace [\#306](https://github.com/liip/LiipImagineBundle/pull/306) ([digitalkaoz](https://github.com/digitalkaoz))
- __\[1.0\]__\[cache\] cache manager has to use isStored inside getBrowserPath method [\#303](https://github.com/liip/LiipImagineBundle/pull/303) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[CacheResolver\] Use binary on store method call. [\#301](https://github.com/liip/LiipImagineBundle/pull/301) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[filter-manager\] make use of binary object. [\#297](https://github.com/liip/LiipImagineBundle/pull/297) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[loader\] remove deprecated phpcr loader [\#292](https://github.com/liip/LiipImagineBundle/pull/292) ([makasim](https://github.com/makasim))
- __\[1.0\]__ Rework data loaders. Introduce mime type guesser.  [\#291](https://github.com/liip/LiipImagineBundle/pull/291) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[tests\] increase code coverage by tests. [\#290](https://github.com/liip/LiipImagineBundle/pull/290) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[Logger\] use PSR one logger [\#286](https://github.com/liip/LiipImagineBundle/pull/286) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[CacheResolver\] Resolver get rid of get browser path [\#284](https://github.com/liip/LiipImagineBundle/pull/284) ([makasim](https://github.com/makasim))
- __\[tests\]__ use real amazon libs in tests. [\#283](https://github.com/liip/LiipImagineBundle/pull/283) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[resolver\] do not expose `targetPath` [\#282](https://github.com/liip/LiipImagineBundle/pull/282) ([makasim](https://github.com/makasim))
- __\[1.0\]__\[resolver\] remove request parameter [\#281](https://github.com/liip/LiipImagineBundle/pull/281) ([makasim](https://github.com/makasim))

## [v0.17.0](https://github.com/liip/LiipImagineBundle/tree/v0.17.0) (2013-12-04)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.16.0...v0.17.0)

- handle image extensions in doctrine loader [\#276](https://github.com/liip/LiipImagineBundle/pull/276) ([dbu](https://github.com/dbu))
- Exclude Tests directory on composer archive [\#274](https://github.com/liip/LiipImagineBundle/pull/274) ([oziks](https://github.com/oziks))
- fix composer require-dev [\#272](https://github.com/liip/LiipImagineBundle/pull/272) ([havvg](https://github.com/havvg))
- Update filters.md [\#267](https://github.com/liip/LiipImagineBundle/pull/267) ([uwej711](https://github.com/uwej711))
- Add comment for image parameter in watermark filter configuration exampl... [\#263](https://github.com/liip/LiipImagineBundle/pull/263) ([USvER](https://github.com/USvER))

## [v0.16.0](https://github.com/liip/LiipImagineBundle/tree/v0.16.0) (2013-09-30)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.15.1...v0.16.0)

- Add Upscale filter [\#248](https://github.com/liip/LiipImagineBundle/pull/248) ([maximecolin](https://github.com/maximecolin))

## [v0.15.1](https://github.com/liip/LiipImagineBundle/tree/v0.15.1) (2013-09-20)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.15.0...v0.15.1)

- Set ContentType of AWS cache object [\#246](https://github.com/liip/LiipImagineBundle/pull/246) ([eXtreme](https://github.com/eXtreme))

## [v0.15.0](https://github.com/liip/LiipImagineBundle/tree/v0.15.0) (2013-09-18)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.14.0...v0.15.0)

- deprecate the phpcr loader as CmfMediaBundle provides a better one now. [\#243](https://github.com/liip/LiipImagineBundle/pull/243) ([dbu](https://github.com/dbu))
- fix missing filename in exception [\#240](https://github.com/liip/LiipImagineBundle/pull/240) ([havvg](https://github.com/havvg))
- Corrected aws-sdk-php link [\#233](https://github.com/liip/LiipImagineBundle/pull/233) ([javiacei](https://github.com/javiacei))

## [v0.14.0](https://github.com/liip/LiipImagineBundle/tree/v0.14.0) (2013-08-21)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.13.0...v0.14.0)

- add AwsS3Resolver for new SDK version [\#227](https://github.com/liip/LiipImagineBundle/pull/227) ([havvg](https://github.com/havvg))

## [v0.13.0](https://github.com/liip/LiipImagineBundle/tree/v0.13.0) (2013-08-19)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.12.0...v0.13.0)

- Watermark loader [\#222](https://github.com/liip/LiipImagineBundle/pull/222) ([KingCrunch](https://github.com/KingCrunch))

## [v0.12.0](https://github.com/liip/LiipImagineBundle/tree/v0.12.0) (2013-08-19)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.11.1...v0.12.0)

- Update dependency 'imagine/imagine' to 0.5.\* [\#221](https://github.com/liip/LiipImagineBundle/pull/221) ([KingCrunch](https://github.com/KingCrunch))

## [v0.11.1](https://github.com/liip/LiipImagineBundle/tree/v0.11.1) (2013-08-05)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.11.0...v0.11.1)

- added documentation on inset and outbound modes of thumbnail filter Documentation \(issue \#207\) [\#210](https://github.com/liip/LiipImagineBundle/pull/210) ([rjbijl](https://github.com/rjbijl))

## [v0.11.0](https://github.com/liip/LiipImagineBundle/tree/v0.11.0) (2013-06-21)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.10.1...v0.11.0)

- Add link filter [\#201](https://github.com/liip/LiipImagineBundle/pull/201) ([EmmanuelVella](https://github.com/EmmanuelVella))
- Thumbnail filter was not applied when allow\_upscale=true and one dimensi... [\#200](https://github.com/liip/LiipImagineBundle/pull/200) ([teohhanhui](https://github.com/teohhanhui))
- Add badge poser in README [\#199](https://github.com/liip/LiipImagineBundle/pull/199) ([agiuliano](https://github.com/agiuliano))
- add docs about allow\_scale of thumbnail filter [\#198](https://github.com/liip/LiipImagineBundle/pull/198) ([havvg](https://github.com/havvg))
- add documentation on S3 object URL options [\#197](https://github.com/liip/LiipImagineBundle/pull/197) ([havvg](https://github.com/havvg))

## [v0.10.1](https://github.com/liip/LiipImagineBundle/tree/v0.10.1) (2013-05-29)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.10.0...v0.10.1)

- mkdir\(\) doesn't take care about the umask [\#189](https://github.com/liip/LiipImagineBundle/pull/189) ([KingCrunch](https://github.com/KingCrunch))
- The quickest PR to review I guess.  [\#188](https://github.com/liip/LiipImagineBundle/pull/188) ([Sydney-o9](https://github.com/Sydney-o9))

## [v0.10.0](https://github.com/liip/LiipImagineBundle/tree/v0.10.0) (2013-05-17)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.9.4...v0.10.0)

- CacheResolver [\#184](https://github.com/liip/LiipImagineBundle/pull/184) ([havvg](https://github.com/havvg))
- fix broken tests on windows [\#179](https://github.com/liip/LiipImagineBundle/pull/179) ([kevinarcher](https://github.com/kevinarcher))

## [v0.9.4](https://github.com/liip/LiipImagineBundle/tree/v0.9.4) (2013-05-14)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.9.3...v0.9.4)

- fix doc of CacheManager::resolve to not lie [\#186](https://github.com/liip/LiipImagineBundle/pull/186) ([dbu](https://github.com/dbu))
- Small documentation fix for getting browserPath for a thumb from controller [\#178](https://github.com/liip/LiipImagineBundle/pull/178) ([leberknecht](https://github.com/leberknecht))
- improve phpcr loader doc [\#177](https://github.com/liip/LiipImagineBundle/pull/177) ([dbu](https://github.com/dbu))
- Allow symfony 2.3 and greater [\#176](https://github.com/liip/LiipImagineBundle/pull/176) ([tommygnr](https://github.com/tommygnr))

## [v0.9.3](https://github.com/liip/LiipImagineBundle/tree/v0.9.3) (2013-04-17)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.9.2...v0.9.3)

- add CacheManagerAwareTrait [\#173](https://github.com/liip/LiipImagineBundle/pull/173) ([havvg](https://github.com/havvg))

## [v0.9.2](https://github.com/liip/LiipImagineBundle/tree/v0.9.2) (2013-04-08)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.9.1...v0.9.2)

- Add background filter [\#171](https://github.com/liip/LiipImagineBundle/pull/171) ([maxbeutel](https://github.com/maxbeutel))
- made the phpcr loader search for the requested path with or without a file extension [\#169](https://github.com/liip/LiipImagineBundle/pull/169) ([lsmith77](https://github.com/lsmith77))
- use composer require command [\#160](https://github.com/liip/LiipImagineBundle/pull/160) ([gimler](https://github.com/gimler))
- Update installation.md [\#159](https://github.com/liip/LiipImagineBundle/pull/159) ([dlondero](https://github.com/dlondero))
- Update README.md [\#158](https://github.com/liip/LiipImagineBundle/pull/158) ([dlondero](https://github.com/dlondero))

## [v0.9.1](https://github.com/liip/LiipImagineBundle/tree/v0.9.1) (2013-02-20)
[Full Changelog](https://github.com/liip/LiipImagineBundle/compare/v0.9.0...v0.9.1)

- added the 'strip' filter [\#152](https://github.com/liip/LiipImagineBundle/pull/152) ([uwej711](https://github.com/uwej711))

## [v0.9.0](https://github.com/liip/LiipImagineBundle/tree/v0.9.0) (2013-02-13)
- add FilterManager::applyFilter [\#150](https://github.com/liip/LiipImagineBundle/pull/150) ([havvg](https://github.com/havvg))
- add "Introduction" chapter to documentation [\#149](https://github.com/liip/LiipImagineBundle/pull/149) ([havvg](https://github.com/havvg))
- split documentation and README into chapters [\#148](https://github.com/liip/LiipImagineBundle/pull/148) ([havvg](https://github.com/havvg))
- Add route options to routing loader [\#138](https://github.com/liip/LiipImagineBundle/pull/138) ([sveriger](https://github.com/sveriger))
- Added a data loader for PHPCR [\#134](https://github.com/liip/LiipImagineBundle/pull/134) ([Burgov](https://github.com/Burgov))
- minor cleanup [\#133](https://github.com/liip/LiipImagineBundle/pull/133) ([havvg](https://github.com/havvg))
- Add image form type [\#130](https://github.com/liip/LiipImagineBundle/pull/130) ([EmmanuelVella](https://github.com/EmmanuelVella))
- New minor Imagine version [\#129](https://github.com/liip/LiipImagineBundle/pull/129) ([jcrombez](https://github.com/jcrombez))
- Pathinfo-related notices in generateUrl\(\) [\#128](https://github.com/liip/LiipImagineBundle/pull/128) ([thanosp](https://github.com/thanosp))
- Updated the Imagine library to version 0.4.0 [\#127](https://github.com/liip/LiipImagineBundle/pull/127) ([ubick](https://github.com/ubick))
- Added some documentation to Outside the web root chapter [\#122](https://github.com/liip/LiipImagineBundle/pull/122) ([nass600](https://github.com/nass600))
- Added PasteFilterLoader [\#118](https://github.com/liip/LiipImagineBundle/pull/118) ([lmcd](https://github.com/lmcd))
- add info on the StreamWrapper of GaufretteBundle [\#115](https://github.com/liip/LiipImagineBundle/pull/115) ([havvg](https://github.com/havvg))
- Properly set config parameter in the container [\#113](https://github.com/liip/LiipImagineBundle/pull/113) ([kevinarcher](https://github.com/kevinarcher))
- Adding cache directory permissions configuration parameter [\#112](https://github.com/liip/LiipImagineBundle/pull/112) ([kevinarcher](https://github.com/kevinarcher))
- Renamed "auto\_clear\_cache" to "cache\_clearer" [\#102](https://github.com/liip/LiipImagineBundle/pull/102) ([Spea](https://github.com/Spea))
- Added option to disable cache\_clearer [\#101](https://github.com/liip/LiipImagineBundle/pull/101) ([Spea](https://github.com/Spea))
- Cache resolver service argument order in readme [\#100](https://github.com/liip/LiipImagineBundle/pull/100) ([johnnypeck](https://github.com/johnnypeck))
- Added GridFS Loader [\#99](https://github.com/liip/LiipImagineBundle/pull/99) ([jdewit](https://github.com/jdewit))
- Update composer.json [\#95](https://github.com/liip/LiipImagineBundle/pull/95) ([krispypen](https://github.com/krispypen))
- Use the basePath in the file path resolver \(useful in "\_dev" or "\_\*" env... [\#92](https://github.com/liip/LiipImagineBundle/pull/92) ([khepin](https://github.com/khepin))
- add basePath injection to filesystem resolver [\#91](https://github.com/liip/LiipImagineBundle/pull/91) ([havvg](https://github.com/havvg))
- add "using the controller as a service" to the documentation [\#88](https://github.com/liip/LiipImagineBundle/pull/88) ([inmarelibero](https://github.com/inmarelibero))
- minor fix in readme [\#87](https://github.com/liip/LiipImagineBundle/pull/87) ([stefax](https://github.com/stefax))
- ensure that hardcoded filter formats are applied [\#86](https://github.com/liip/LiipImagineBundle/pull/86) ([lsmith77](https://github.com/lsmith77))
- fixed \#81 cache clearer only registered for sf2.1 [\#82](https://github.com/liip/LiipImagineBundle/pull/82) ([digitalkaoz](https://github.com/digitalkaoz))
- Issue 43 - Added a cache clearer for generated images [\#80](https://github.com/liip/LiipImagineBundle/pull/80) ([sixty-nine](https://github.com/sixty-nine))
- added NoCacheResolver [\#76](https://github.com/liip/LiipImagineBundle/pull/76) ([ghost](https://github.com/ghost))
- Fixed errors in README.md [\#75](https://github.com/liip/LiipImagineBundle/pull/75) ([iamdto](https://github.com/iamdto))
- add LoggerInterface to AmazonS3Resolver [\#70](https://github.com/liip/LiipImagineBundle/pull/70) ([havvg](https://github.com/havvg))
- fix AmazonS3Resolver [\#69](https://github.com/liip/LiipImagineBundle/pull/69) ([havvg](https://github.com/havvg))
- several fixes to the AmazonS3Resolver based on feedback [\#68](https://github.com/liip/LiipImagineBundle/pull/68) ([havvg](https://github.com/havvg))
- move getFilePath to AbstractFilesystemResolver [\#67](https://github.com/liip/LiipImagineBundle/pull/67) ([havvg](https://github.com/havvg))
- add AmazonS3Resolver and ResolverInterface::remove [\#66](https://github.com/liip/LiipImagineBundle/pull/66) ([havvg](https://github.com/havvg))
- Throwing an error if source image doesn't exist [\#65](https://github.com/liip/LiipImagineBundle/pull/65) ([fixe](https://github.com/fixe))
- add GaufretteFilesystemLoader [\#63](https://github.com/liip/LiipImagineBundle/pull/63) ([havvg](https://github.com/havvg))
- Mark image services as non public [\#62](https://github.com/liip/LiipImagineBundle/pull/62) ([lstrojny](https://github.com/lstrojny))
- Updates PdfTransformer so that imagick is injected [\#61](https://github.com/liip/LiipImagineBundle/pull/61) ([lucasaba](https://github.com/lucasaba))
- add crop filter; add missing option for thumbnail filter [\#58](https://github.com/liip/LiipImagineBundle/pull/58) ([gimler](https://github.com/gimler))
- Add file transformers to the file loader [\#57](https://github.com/liip/LiipImagineBundle/pull/57) ([lucasaba](https://github.com/lucasaba))
- Use of protected class properties in FilesystemLoader [\#54](https://github.com/liip/LiipImagineBundle/pull/54) ([petrjaros](https://github.com/petrjaros))
- 'cache\_resolver' property name change [\#53](https://github.com/liip/LiipImagineBundle/pull/53) ([petrjaros](https://github.com/petrjaros))
- add composer.json [\#51](https://github.com/liip/LiipImagineBundle/pull/51) ([iampersistent](https://github.com/iampersistent))
- Fix for last version of symfony [\#50](https://github.com/liip/LiipImagineBundle/pull/50) ([benji07](https://github.com/benji07))
- Allowed a file extension to be inferred for source files without one [\#47](https://github.com/liip/LiipImagineBundle/pull/47) ([web-dev](https://github.com/web-dev))
- Added a configuration option for the data root. [\#46](https://github.com/liip/LiipImagineBundle/pull/46) ([web-dev](https://github.com/web-dev))
- README update: source img outside web root [\#45](https://github.com/liip/LiipImagineBundle/pull/45) ([scoolen](https://github.com/scoolen))
- Fixing typo in README.md [\#44](https://github.com/liip/LiipImagineBundle/pull/44) ([stefanosala](https://github.com/stefanosala))
- update template extension and helper names [\#41](https://github.com/liip/LiipImagineBundle/pull/41) ([iampersistent](https://github.com/iampersistent))
- Refactor RelativeResize code and add documentation [\#39](https://github.com/liip/LiipImagineBundle/pull/39) ([jmikola](https://github.com/jmikola))
- Add Resize and RelativeResize filters [\#37](https://github.com/liip/LiipImagineBundle/pull/37) ([jmikola](https://github.com/jmikola))
- Extracted the abstract class Resolver from WebPathResolver [\#35](https://github.com/liip/LiipImagineBundle/pull/35) ([sixty-nine](https://github.com/sixty-nine))
- fix service name [\#34](https://github.com/liip/LiipImagineBundle/pull/34) ([lenar](https://github.com/lenar))
- Removed webRoot logic outside controller [\#28](https://github.com/liip/LiipImagineBundle/pull/28) ([LouTerrailloune](https://github.com/LouTerrailloune))
- Fixed redirect using wrong variable [\#27](https://github.com/liip/LiipImagineBundle/pull/27) ([Spea](https://github.com/Spea))
- Tweak response creation [\#26](https://github.com/liip/LiipImagineBundle/pull/26) ([lsmith77](https://github.com/lsmith77))
- fixed unit tests, fixes GH-22 [\#24](https://github.com/liip/LiipImagineBundle/pull/24) ([ghost](https://github.com/ghost))
- added missing docblock [\#20](https://github.com/liip/LiipImagineBundle/pull/20) ([LouTerrailloune](https://github.com/LouTerrailloune))
- allow-all default setting for liip\_imagine.formats [\#14](https://github.com/liip/LiipImagineBundle/pull/14) ([ghost](https://github.com/ghost))
- added support for many filter transformations in one filter set \(style\), fixes GH-1 [\#11](https://github.com/liip/LiipImagineBundle/pull/11) ([ghost](https://github.com/ghost))
- fixed ImagineLoader - cache prefix was not used in urls [\#6](https://github.com/liip/LiipImagineBundle/pull/6) ([ghost](https://github.com/ghost))
- fixed CachePathResolver\#getBrowserPath [\#5](https://github.com/liip/LiipImagineBundle/pull/5) ([ghost](https://github.com/ghost))
- Added check for the existence of extension info [\#147](https://github.com/liip/LiipImagineBundle/pull/147) ([thanosp](https://github.com/thanosp))
- add Tests for bundle features [\#140](https://github.com/liip/LiipImagineBundle/pull/140) ([havvg](https://github.com/havvg))



\* *This Change Log was automatically generated by [github_changelog_generator](https://github.com/skywinder/Github-Changelog-Generator)*
