<?php

namespace app\models;

/**
 * Класс с глобальными константами.
 */

class Consts
{
	//Токен для отравки сообщений VK
	const VK_ACCESS_TOKEN_SEND = 'VK_ACCESS_TOKEN_SEND';
	//Токен для получения информации из БД VK
	const VK_ACCESS_TOKEN_GET_INFO = 'VK_ACCESS_TOKEN_GET_INFO';
	//Максимальное количество пользователей в выборке, со стороны VK API максимальное ограничение в 1000
	const VK_PAGE_SIZE = 1000;
}
