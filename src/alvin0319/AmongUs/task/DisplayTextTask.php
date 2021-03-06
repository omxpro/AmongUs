<?php

/*
 *      _                                _   _
 *    / \   _ __ ___   ___  _ __   __ _| | | |___
 *   / _ \ | '_ ` _ \ / _ \| '_ \ / _` | | | / __|
 *  / ___ \| | | | | | (_) | | | | (_| | |_| \__ \
 * /_/   \_\_| |_| |_|\___/|_| |_|\__, |\___/|___/
 *                                |___/
 *
 * A PocketMine-MP plugin that implements AmongUs
 *
 * Copyright (C) 2020 alvin0319
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @author alvin0319
 */

declare(strict_types=1);

namespace alvin0319\AmongUs\task;

use alvin0319\AmongUs\game\Game;
use pocketmine\scheduler\Task;

use function strlen;
use function substr;

class DisplayTextTask extends Task{
	/** @var Game */
	protected $game;
	/** @var string */
	protected $title;
	/** @var string */
	protected $subtitle;
	/** @var int */
	protected $progress = 0;
	/** @var int */
	protected $max = -1;

	public function __construct(Game $game, string $title, string $subtitle){
		$this->game = $game;
		$this->title = $title;
		$this->subtitle = $subtitle;

		$this->max = strlen($title);
	}

	public function onRun(int $currentTick) : void{
		foreach($this->game->getPlayers() as $player){
			$player->sendTitle(" ", substr($this->title, 0, $this->progress));
		}
		if($this->progress === $this->max){
			if($this->subtitle !== ""){
				foreach($this->game->getPlayers() as $player){
					$player->sendTitle(" ", $this->subtitle);
				}
			}
			$this->getHandler()->cancel();
			return;
		}
		++$this->progress;
	}
}