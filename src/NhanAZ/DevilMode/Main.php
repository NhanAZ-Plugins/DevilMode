<?php

declare(strict_types=1);

namespace NhanAZ\DevilMode;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

	protected function onEnable(): void {
		$this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
		if ($command->getName() !== "devil" || count($args) !== 0) {
			return false;
		}
		if (!$sender instanceof Player) {
			$sender->sendMessage($this->message("CmdInClsMsg"));
			return true;
		}

		$session = Session::get($sender);
		$enabled = !$session->isDevilMode();
		$session->setDevilMode($enabled);
		$sender->sendMessage($this->message("Prefix") . $this->message($enabled ? "EnableMsg" : "DisableMsg"));
		return true;
	}

	public function onEntityDamage(EntityDamageEvent $event): void {
		$entity = $event->getEntity();
		if ($entity instanceof Player) {
			$session = Session::get($entity);
			if ($session->isDevilMode()) {
				$event->cancel();
			}
		}
	}

	public function onPlayerExhaust(PlayerExhaustEvent $event): void {
		$player = $event->getPlayer();
		if (!$player instanceof Player) {
			return;
		}
		$session = Session::get($player);
		if ($session->isDevilMode()) {
			$event->cancel();
		}
	}

	private function message(string $key): string {
		$default = match ($key) {
			"Prefix" => "§f[§eDevilMode§f]§r ",
			"EnableMsg" => "§aDevil mode enabled!",
			"DisableMsg" => "§cDevil mode disabled!",
			"CmdInClsMsg" => "§cYou can't use this command in the terminal",
			default => "",
		};
		$value = $this->getConfig()->get($key, $default);
		if (is_string($value)) {
			return $value;
		}
		$this->getLogger()->warning("Configuration value '$key' must be a string.");
		return $default;
	}
}
