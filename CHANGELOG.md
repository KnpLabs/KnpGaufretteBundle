# Changelog

## [1.0.0](https://github.com/KnpLabs/KnpGaufretteBundle/compare/v0.10.0...v1.0.0) (2026-07-24)


### ⚠ BREAKING CHANGES

* AdapterFactoryInterface::create() now declares `string $id`. Any class implementing this interface must update its create() signature to add the `string` type declaration on the $id parameter.
* drop PHP 7.4 support

### Features

* add full PHP 8.0–8.5 support ([#298](https://github.com/KnpLabs/KnpGaufretteBundle/issues/298)) ([f96eb67](https://github.com/KnpLabs/KnpGaufretteBundle/commit/f96eb678a88c9457311f3a48f3b09e926b96b671))
* update gaufrette ([#295](https://github.com/KnpLabs/KnpGaufretteBundle/issues/295)) ([ec11a84](https://github.com/KnpLabs/KnpGaufretteBundle/commit/ec11a8461656885c2065870fb54dc37aa4a30a02))


### Miscellaneous Chores

* update actions/checkout to v7 in CI workflow ([#297](https://github.com/KnpLabs/KnpGaufretteBundle/issues/297)) ([2ceca45](https://github.com/KnpLabs/KnpGaufretteBundle/commit/2ceca459b47283e88f6fac01c5a18703bc55b059))

## [Unreleased] — PHP 8.0–8.5 compatibility (MAJOR)

### ⚠ BREAKING CHANGES

* **`AdapterFactoryInterface::create()`** now declares `string $id` as an explicit parameter type.
  Any class implementing this interface must update its `create()` signature accordingly:
  ```php
  // Before
  public function create(ContainerBuilder $container, $id, array $config): void { … }
  // After
  public function create(ContainerBuilder $container, string $id, array $config): void { … }
  ```

### Features

* Full PHP 8.0–8.5 support: `composer install` resolves cleanly and all tests pass on all six versions.
* Expand `symfony/phpunit-bridge` constraint to `^6.0|^7.0|^8.0` (previously `^7.0|^8.0`,
  which blocked PHP 8.0/8.1 since Bridge 7.x requires PHP 8.2).

### Internal Changes

* Add explicit type declarations to class properties in `FilesystemMap`, `KnpGaufretteExtension`,
  and `FilesystemKeysCommand`.
* Remove dead `use DefinitionDecorator` import from `KnpGaufretteExtension`.
* Replace legacy `array()` literals with `[]` short syntax in `KnpGaufretteExtension` and
  both compiler passes.
* Update `phpunit.xml.dist` schema reference from PHPUnit 9.3 to PHPUnit 10.5.

---

## [0.10.0](https://github.com/KnpLabs/KnpGaufretteBundle/compare/v0.9.0...v0.10.0) (2026-07-18)

### Features

* Allow Symfony 8 (#290) ([7981baf](https://github.com/KnpLabs/KnpGaufretteBundle/commit/7981baf0327895f285a005e2a0ef1c0b9d8d87ce))


### Miscellaneous Chores

* update Symfony dependency injection requirement to ^5.1 ([682c6f5](https://github.com/KnpLabs/KnpGaufretteBundle/commit/682c6f516f56cd8e5e830e3ff438378ec4f9f8ca))

v0.8.0 - 2022-10-21
===================

Adds :

- BC Break: Adding Types (remove deprecation notices triggered by Symfony)
  _Please notice that the v0.8.0 is a major version, therefore if you extended any class or interface, you MUST implement it with types now._ 
- Support for Gaufrette 0.11
  - With support for the new version of Google Client (compatible with PHP 8.0+)

Fixes :

- Command documentation now print the right information (#242)

Removes :

- Support for PHP < 7.4

v0.7.2
======

Fixes:

- Add support for PHP 8.1 (#256)

v0.7.1
======

Fixes :

- Be able to install Gaufrette [v0.9.0](https://github.com/KnpLabs/Gaufrette/releases/tag/v0.9.0)
(#233).

v0.7.0
======

Changes :

- Bump minimum Symfony 4 version to 4.2 to fix vulnerability issue (#228)
- Symfony 5 support (#227)
- PHP 7.4 support (#227)

Fixes :

- Symplify TreeBuilder usage backward compatibility (#223)

Thank you @flug, @nm2107 and @p365labs for your contributions ! 

v0.6.1
======

## Fixes

- Keep compatibility with Symfony 3.4 as it is LTS (#221)
- Fix Symfony 4.2 command deprecation about services usage (#210)
- Fix Symfony 3.4 deprecation: Autowiring based on types (#215)

Thank you @ahilke, @nicolasmure and @timgregg for your contributions ! 

v0.6.0
======

Changes:
- Require PHP 7.1 as minimum (previous php versions are EOL) (#204)
- PHP 7.3 support (#204)
- Update Gaufrette dep to v0.8 (#204)
- Update Symfony deps to v4 (#204)

Fixes:
- Make composer respects semver versioning (#196)
- Update README for Symfony 4 directory structure (#206)
- Remove TreeBuilder deprecations (#207)

Documentation fixes:
- Fixed documentation for phpseclib 2.0 (#189)
- Simplified aws s3 docs (#193)
- Pretty print doc block (#195)

Thanks to @aaronadal, @Awkan, @Nek-, @nicolasmure and @OskarStark for their
contributions!

v0.5.3
======

- Fix composer.json validity (#184)
- Be able to install Gaufrette v0.6 (#185)

v0.5.2
======

- Declare command as service to fix sf3.4 deprecation (#183)

v0.5.1
======

- Be able to install Gaufrette 0.5 (#178)

v0.5.0
======

* Add `utf8` parameter to FTP adapter config
* Add some docs about S3 regions
* Fix config example for S3 adapter (#153)
* Add `multi_container_mode` to Azure adapter config (#158)
* Add missing documentation about `detect_content_type` for S3 adapter (#161)
* Fix configuration processing (#163)
* Fix deprecation warnings with Symfony >= 3.3 (#165)
* Add docs about metapackages (#168)
* Fix doc link (#169)
* Adding Symfony 4 support (#171)
* Use PHPUnit\Framework\TestCase instead of PHPUnit_Framework_TestCase (#172)
* Bump Gaufrette version (#173)
* Add use cases documentation (#175)
* Declare filesystem services as public (#176)
* Drop support for old PHP versions 5.3, 5.4, 5.5 (#177)

Thanks to: @000panther, @NiR-, @jspizziri, @kesslerdev, @vyacheslavk, @Lctrs, @nicolasmure, @silvioq, @bocharsky-bw, @carusogabriel, @7thcubic, @aguidis, @bluntelk, @rjd22.
