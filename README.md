# DevilMode

DevilMode lets a player toggle protection from damage and exhaustion on an Axolotl-PM server.

[![Build and validate DevilMode plugin](https://github.com/NhanAZ-Plugins/DevilMode/actions/workflows/build.yml/badge.svg)](https://github.com/NhanAZ-Plugins/DevilMode/actions/workflows/build.yml)

## Features

- Cancel damage to a player while that player's Devil Mode is enabled.
- Cancel exhaustion events for a player while the mode is enabled.
- Keep each player's toggle in memory for the current session.

Devil Mode starts disabled. The toggle is not saved across a player reconnect or a server restart.

## Requirements and compatibility

The manifest requires Axolotl-PM API `5.0.0`. The server requires PHP 8.1 or newer. The [build workflow](.github/workflows/build.yml) pins the server source used for PHPStan and PHAR validation. A passing build on one source revision does not establish compatibility with every Axolotl-PM 5.x release.

The plugin has no runtime virion dependencies.

## Installation and usage

Download a verified PHAR from [GitHub Releases](https://github.com/NhanAZ-Plugins/DevilMode/releases), place it in the server's `plugins` directory and restart the server. Keep the previous PHAR and a copy of the configuration for rollback.

Players with `devil.command` can run `/devil` to enable the mode and run it again to disable the mode. The permission is granted to operators by default. The command cannot toggle a player from the server console.

## Configuration

The plugin creates `plugins/DevilMode/config.yml` on first startup. Edit the message strings and restart the server to load them.

| Key | Purpose |
|---|---|
| `Prefix` | Text before toggle messages |
| `EnableMsg` | Message after enabling the mode |
| `DisableMsg` | Message after disabling the mode |
| `CmdInClsMsg` | Message sent when the command runs from the console |

If one of these values is not a string, the plugin logs a warning and uses the bundled default for that message without rewriting the configuration file.

## Build and development

The [GitHub Actions workflow](.github/workflows/build.yml) runs a session state check and uses [DevTools](https://github.com/NhanAZ/DevTools) to analyze the source at PHPStan level max, build the plugin PHAR and validate it before artifact upload. The workflow pins DevTools and the Axolotl-PM source to verified commits.

Run `php tests/session.php` for the standalone state check. Static analysis and a server boot do not replace a connected player test of damage and exhaustion events.

## Support and license

Report defects through [GitHub Issues](https://github.com/NhanAZ-Plugins/DevilMode/issues) or [NhanAZ Discord](https://discord.gg/j2X83ujT6c). DevilMode is licensed under the [GNU General Public License v3.0](LICENSE).
