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
