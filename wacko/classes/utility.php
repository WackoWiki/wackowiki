<?php

class Utility
{
	//Constructor
	function __construct(&$wacko)
	{
		$this->wacko = &$wacko;
	}

	function untag($xml, $tag)
	{
		$z = strpos ($xml, "<$tag>");

		if ($z !== false)
		{
			$z += strlen ($tag) + 2;
			$z2 = strpos ($xml, "</$tag>");

			if ($z2 !== false)
			{
				$final = substr ($xml, $z, $z2 - $z);

				if (strpos($final, '<![CDATA[') === 0)
				{
					$final = substr($final, 9);
					$final = substr($final, 0, strlen($final) - 3);
				}

				return $final;
			}
		}

		return '';
	}
}

?>