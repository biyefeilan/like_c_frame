<?php
/**
 * 
 * @author 陈波
 *
 */
class Ip {
	
	/**
	 * ip比较大小
	 * @param string $ip1
	 * @param string $ip2
	 * @param int $ip_version (0->自动判断,4,6)
	 * @return boolean|number
	 */
	public static function ipcmp($ip1, $ip2, $ip_version=0)
	{
		if ($ip_version==4 || ($ip_version==0 && Ip::isipv4($ip1) && Ip::isipv4($ip2)) )
		{
			$r = ip2long($ip1) - ip2long($ip2);
			return $r == 0 ? 0 : ($r > 0 ? 1 : -1);
		}
		else if ( Ip::isipv6($ip1) && Ip::isipv6($ip2) )
		{
			return strcmp(Ip::ipv62long($ip1), Ip::ipv62long($ip2));
		}

		return false;
	}
	
	public static function ipv62long($ip)
	{
		$ip_n = inet_pton($ip);
		$bits = 15; // 16 x 8 bit = 128bit (ipv6)
		while ($bits >= 0)
		{
			$bin = sprintf("%08b",(ord($ip_n[$bits])));
			$ipbin = $bin.$ipbin;
			$bits--;
		}
		return $ipbin;
	}
	
	public static function long2ipv6($bin)
	{
		$pad = 128 - strlen($bin);
		for ($i = 1; $i <= $pad; $i++)
		{
			$bin = "0".$bin;
		}
		$bits = 0;
		while ($bits <= 7)
		{
			$bin_part = substr($bin,($bits*16),16);
			$ipv6 .= dechex(bindec($bin_part)).":";
			$bits++;
		}
		return inet_ntop(inet_pton(substr($ipv6,0,-1)));
	}
	
	public static function isipv4($ip)
	{
		return (bool)preg_match('/^\s*((25[0-5]|2[0-4]\d|[0-1]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[0-1]?\d\d?)\s*$/', $ip);
	}
	
	public static function isipv6($ip)
	{
		return (bool)preg_match('/^\s*((([0-9A-Fa-f]{1,4}:){7}(([0-9A-Fa-f]{1,4})|:))|(([0-9A-Fa-f]{1,4}:){6}(:|((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})|(:[0-9A-Fa-f]{1,4})))|(([0-9A-Fa-f]{1,4}:){5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){4}(:[0-9A-Fa-f]{1,4}){0,1}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){3}(:[0-9A-Fa-f]{1,4}){0,2}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){2}(:[0-9A-Fa-f]{1,4}){0,3}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:)(:[0-9A-Fa-f]{1,4}){0,4}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(:(:[0-9A-Fa-f]{1,4}){0,5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})))(%.+)?\s*$/', $ip);
	}
	
	/**
	 * ipv6地址转换成四个int数组返回（0-3为最高位到最低位）ipv4的数据保存在arr[3]其余为0
	 * @param $ip ipv4或者ipv6地址
	 * @param $ip_version 0-自动判断 4-ipv4 6-ipv6
	 * @return array
	 */
	public static function ip2arr($ip, $ip_version=0)
	{
		$arr = array(0=>0, 1=>0, 2=>0, 3=>0);
		
		if ($ip_version==4 || ($ip_version==0 && Ip::isipv4($ip)) )
		{
			$arr[3] = ip2long($ip);
		}
		else
		{
			$str = Ip::ipv62long($ip);
			for ($i=0; $i<4; ++$i)
			{
				$arr[$i] = bindec(substr($str, $i*32, 32));
			}
		}
		
		return $arr;
	}
	
	/**
	 * for windows
	 * @param unknown_type $ip_version
	 */
	public static function getServerIp($ip_version=4)
	{
		static $server_ip = null;
		if (isset($server_ip))
		{
			return isset($server_ip[$ip_version]) ? $server_ip[$ip_version] : exit('wrong ip version');
		}
	
		$server_ip = array(
				'4' => '127.0.0.1',
				'6' => '::1',
		);
	
		if (function_exists('exec'))
		{
			exec('ipconfig', $lines, $ret);
			if ($ret == 0)
			{
				foreach ($lines as $line)
				{
					if (preg_match('/^\s*ip/i', $line))
					{
						if (preg_match('/:\s*(.+)/', $line, $ip))
						{
							if ( Ip::isipv4($ip[1]) )
							{
								$server_ip['4'] = $ip[1];
							}
							else if ( Ip::isipv6($ip[1]) )
							{
								$server_ip['6'] = $ip[1];
							}
						}
					}
				}
			}
		}
		else if (isset($_SERVER['HTTP_HOST']))
		{
			$host = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], ':'));
			if ( Ip::isipv4($host) )
			{
				$server_ip['4'] = $host;
			}
			else if ( Ip::isipv6($host) )
			{
				$server_ip['6'] = $host;
			}
		}
	
		return self::getServerIp($ip_version);
	}
	
}

?>