<?php

if ( ! function_exists('array_except'))
{
  /**
   * Get all of the given array except for a specified array of items.
   *
   * @param  array  $array
   * @param  array  $keys
   * @return array
   */
  function array_except($array, $keys)
  {
    return array_diff_key($array, array_flip((array) $keys));
  }
}

if ( ! function_exists('preg_match_with_named_groups'))
{
  /**
   * A wrapper for preg_match() function
   *
   * Worth using when regex pattern contains named groups.
   *
   * More on this topic:
   * http://stackoverflow.com/questions/3275963/how-to-return-only-named-groups-with-preg-match-or-preg-match-all
   *
   * By default calling preg_match() with following regex:
   *
   * '#(?<locale>/[a-z]{2,3})?/products/(\d+)#'
   *
   * and following subject:
   *
   * '/en/products/43'
   *
   * would result in $matches containing an array similar to:
   *
   * array('locale' => 'en', 1 => 'en', 2 => 43);
   *
   * As you can see the locale is duplicated. We don't always want that.
   * So in this function we strip the $matches array down to:
   *
   * array('locale' => 'en', 1 => 199);
   *
   * Note that unnamed groups are ordered numerically and start with 1
   *
   * @param  string   $pattern
   * @param  string   $subject
   * @param  array    $matches
   * @param  int      $flags
   * @param  int      $offset
   * @return void
   */
  function preg_match_with_named_groups($pattern, $subject, &$matches, $flags = 0, $offset = 0)
  {
    $preg_match_return_value = preg_match($pattern, $subject, $matches, $flags, $offset);

    $last_group_key = null;
    $last_group_value = null;
    $sorted_matches = array();
    foreach( $matches as $group_key => $group_value )
    {
      if(
        // we shouldn't worry about first key as it is usually the whole matched string
        $group_key !== 0
        // only continue if current group key is numeric..
        && is_numeric($group_key)
        // ..while last group key was not numeric (smells like it was a named group, itsn't it?)
        && !is_numeric($last_group_key)
        // ..and they have same values - gotcha! It's a duplicated match item for a named group. Strip it now!
        && $group_value === $last_group_value
      ) {

      } else {
        if( is_numeric($group_key) )
        {
          array_push($sorted_matches, $group_value);
        } else {
          $sorted_matches[$group_key] = $group_value;
        }
      }

      // Remember this group key and value for comparison in next iteration
      $last_group_key = $group_key;
      $last_group_value = $group_value;
    }

    $matches = $sorted_matches;

    return $preg_match_return_value;
  }
}

if ( ! function_exists('convert_query_parameters_to_array'))
{
  function convert_query_parameters_to_array($subject)
  {
    $groups = explode('&', $subject);
    foreach( $groups as $key => $value ) {

      if( strpos($value, '=') !== false )
      {
        list($param_name, $param_value) = array_values(explode('=', $value));
        if( !empty($param_name) ) $groups[$param_name] = $param_value;
      } elseif (!empty($value))  {
        $groups[$value] = null;
      }

      unset($groups[$key]);
    }

    return $groups;
  }
}

if ( ! function_exists('starts_with'))
{
  /**
   * Determine if a given string starts with a given substring.
   *
   * @param  string  $haystack
   * @param  string|array  $needle
   * @return bool
   */
  function starts_with($haystack, $needles)
  {
    foreach ((array) $needles as $needle)
    {
      if ($needle != '' && strpos($haystack, $needle) === 0) return true;
    }

    return false;
  }
}

if ( ! function_exists('array_first'))
{
  /**
   * Return the first element in an array passing a given truth test.
   *
   * @param  array    $array
   * @param  Closure  $callback
   * @param  mixed    $default
   * @return mixed
   */
  function array_first($array, $callback, $default = null)
  {
    foreach ($array as $key => $value)
    {
      if (call_user_func($callback, $key, $value)) return $value;
    }

    return value($default);
  }
}

if ( ! function_exists('str_is'))
{
  /**
   * Determine if a given string matches a given pattern.
   *
   * @param  string  $pattern
   * @param  string  $value
   * @return bool
   */
  function str_is($pattern, $value)
  {
    if ($pattern == $value) return true;

    $pattern = preg_quote($pattern, '#');

    // Asterisks are translated into zero-or-more regular expression wildcards
    // to make it convenient to check if the strings starts with the given
    // pattern such as "library/*", making any string check convenient.
    $pattern = str_replace('\*', '.*', $pattern).'\z';

    return (bool) preg_match('#^'.$pattern.'#', $value);
  }
}

if ( ! function_exists('value'))
{
  /**
   * Return the default value of the given value.
   *
   * @param  mixed  $value
   * @return mixed
   */
  function value($value)
  {
    return $value instanceof Closure ? $value() : $value;
  }
}

if ( ! function_exists('normalize_path'))
{
  /**
   * Convert path with relative references to path with absolute
   * references
   *
   * For example:
   *
   * Input:   dir1/dir2/../dir3
   * Output:  dir1/dir3
   *
   * @param  string  $path
   * @return string
   */
  function normalize_path($path)
  {
    $parts = array();// Array to build a new path from the good parts
    $path = str_replace('\\', '/', $path);// Replace backslashes with forwardslashes
    $path = preg_replace('/\/+/', '/', $path);// Combine multiple slashes into a single slash
    $segments = explode('/', $path);// Collect path segments
    $test = '';// Initialize testing variable
    foreach($segments as $segment)
    {
      if($segment != '.')
      {
        $test = array_pop($parts);
        if(is_null($test))
          $parts[] = $segment;
        else if($segment == '..')
        {
          if($test == '..')
            $parts[] = $test;

          if($test == '..' || $test == '')
            $parts[] = $segment;
        }
        else
        {
          $parts[] = $test;
          $parts[] = $segment;
        }
      }
    }
    return implode('/', $parts);
  }

}

if ( ! function_exists('fm'))
{
  /**
   * Format Money - provide unformatted number (float or integer)
   * Locale identifier (like en_US.UTF-8), symbol (like AUD) and sign (like $)
   *
   * Function will do it's best to guess the best output possible, degradating gracefully
   * according to the arguments it received
   *
   * For example:
   *
   * fm(1234.44, 'en_US.UTF-8') === 1,234.44
   * fm(1234.44, 'de_DE.UTF-8', 'EU') === EU 1.234,44
   * fm(-1234.44, 'de_DE.UTF-8', 'EU', '€') === -€1.234,44
   *
   * If locale is not found , formatting will fallback to US format: x,xxx.xx
   * For example:
   *
   * fm(-1234.44, 'foobar', 'AUD', '$') === -$1,234.44
   * ..and..
   * fm(-1234.44, 'foobar', '', '$') === -$1,234.44
   * ..but..
   * fm(-1234.44, 'foobar', 'AUD') === AUD -1,234.44
   *
   * @param  double  $amount
   * @param  string  $locale
   * @param  string   $symbol
   * @param  string   $sign
   * @return array
   */
  function fm($amount, $locale = '', $symbol = '', $sign = '')
  {
    setlocale(LC_MONETARY, $locale);

    // Test locale
    if( strlen(money_format('%.0n', 0)) !== 1
        && strlen(money_format('%.0i', 0)) !== 1 ) {

      $num_decimals = (intval($amount) == $amount) ? 0 : 2;
      $formatted_amount = money_format("%!.{$num_decimals}n", $amount);

    // Fallback to manual formatting by symbol
    } else {

      $formatted_amount = fc($amount, $symbol);

    }

    // Add sign/symbol to formatted number
    // and return
    return decorate_amount($formatted_amount, $sign, $symbol);
  }
}

if ( ! function_exists('fd'))
{
  function fd($value, $decimals = 2)
  {
    return sprintf("%0.{$decimals}f", $value);
  }
}

if ( ! function_exists('decorate_amount'))
{
  /**
   * Inject currency sign or symbol into Amount
   * Example:
   * convert
   * -1,234.55 into -$1,234.55
   * or
   * 1.25 into AUD 1.25
   *
   * @param  double  $amount
   * @param  string   $sign
   * @param  string   $symbol
   * @return array
   */
  function decorate_amount($amount, $sign = '', $symbol = '') {
    if( !empty($sign) ) {

      if( substr($amount, 0, 1) === '-' ) {
        $decorated_amount = '-' . $sign . substr($amount, 1);
      } else {
        $decorated_amount = $sign . $amount;
      }
      return $decorated_amount;

    } else if( !empty($symbol) ) {
      return $symbol . ' ' . $amount;
    } else {
      return $amount;
    }
  }
}

if ( ! function_exists('exchange_rate_format'))
{
  /**
   * 'exchange_rate_format' Function to format Exchange Rate Quote
   *
   * Examples:
   * exchange_rate_format(5253.075255);   // 5253.0752
   * exchange_rate_format(3.181921, 5);   // 3.18192
   * exchange_rate_format(61.2800);       // 61.28
   *
   * @param flatcurr  The number being formatted
   * @param decimals  Sets the number of decimal points
   * @return formatted number
   */
  function exchange_rate_format($number, $decimals = 4){
    return rtrim(number_format($number, $decimals, '.', ''), 0);
  }
}

if ( ! function_exists('fc'))
{
  /**
   * 'formatcurrency' Function to convert your floating int into a
   *
   * Examples:
   * formatcurrency(1000045.25);       //1,000,045.25 (USD)    
   * formatcurrency(1000045.25, "CHF");    //1'000'045.25
   * formatcurrency(1000045.25, "EUR");    //1.000.045,25
   * formatcurrency(1000045, "JPY");     //1,000,045
   * formatcurrency(1000045, "LBP");     //1 000 045
   * formatcurrency(1000045.25, "INR");    //10,00,045.25
   *
   * Taken from:
   * http://www.joelpeterson.com/blog/2011/03/formatting-over-100-currencies-in-php/
   *
   * @author Joel Peterson - @joelasonian - www.joelpeterson.com
   * @param flatcurr  float integer to convert
   * @param curr  string of desired currency format
   * @return formatted number
   */
  function fc($floatcurr, $curr = null){
    if( $curr === null ) $curr = 'USD';
    $currencies['ARS'] = array(2,',','.');      //  Argentine Peso
    $currencies['AMD'] = array(2,'.',',');      //  Armenian Dram
    $currencies['AWG'] = array(2,'.',',');      //  Aruban Guilder
    $currencies['AUD'] = array(2,'.',' ');      //  Australian Dollar
    $currencies['BSD'] = array(2,'.',',');      //  Bahamian Dollar
    $currencies['BHD'] = array(3,'.',',');      //  Bahraini Dinar
    $currencies['BDT'] = array(2,'.',',');      //  Bangladesh, Taka
    $currencies['BZD'] = array(2,'.',',');      //  Belize Dollar
    $currencies['BMD'] = array(2,'.',',');      //  Bermudian Dollar
    $currencies['BOB'] = array(2,'.',',');      //  Bolivia, Boliviano
    $currencies['BAM'] = array(2,'.',',');      //  Bosnia and Herzegovina, Convertible Marks
    $currencies['BWP'] = array(2,'.',',');      //  Botswana, Pula
    $currencies['BRL'] = array(2,',','.');      //  Brazilian Real
    $currencies['BND'] = array(2,'.',',');      //  Brunei Dollar
    $currencies['CAD'] = array(2,'.',',');      //  Canadian Dollar
    $currencies['KYD'] = array(2,'.',',');      //  Cayman Islands Dollar
    $currencies['CLP'] = array(0,'','.');     //  Chilean Peso
    $currencies['CNY'] = array(2,'.',',');      //  China Yuan Renminbi
    $currencies['COP'] = array(2,',','.');      //  Colombian Peso
    $currencies['CRC'] = array(2,',','.');      //  Costa Rican Colon
    $currencies['HRK'] = array(2,',','.');      //  Croatian Kuna
    $currencies['CUC'] = array(2,'.',',');      //  Cuban Convertible Peso
    $currencies['CUP'] = array(2,'.',',');      //  Cuban Peso
    $currencies['CYP'] = array(2,'.',',');      //  Cyprus Pound
    $currencies['CZK'] = array(2,'.',',');      //  Czech Koruna
    $currencies['DKK'] = array(2,',','.');      //  Danish Krone
    $currencies['DOP'] = array(2,'.',',');      //  Dominican Peso
    $currencies['XCD'] = array(2,'.',',');      //  East Caribbean Dollar
    $currencies['EGP'] = array(2,'.',',');      //  Egyptian Pound
    $currencies['SVC'] = array(2,'.',',');      //  El Salvador Colon
    $currencies['ATS'] = array(2,',','.');      //  Euro
    $currencies['BEF'] = array(2,',','.');      //  Euro
    $currencies['DEM'] = array(2,',','.');      //  Euro
    $currencies['EEK'] = array(2,',','.');      //  Euro
    $currencies['ESP'] = array(2,',','.');      //  Euro
    $currencies['EUR'] = array(2,',','.');      //  Euro
    $currencies['FIM'] = array(2,',','.');      //  Euro
    $currencies['FRF'] = array(2,',','.');      //  Euro
    $currencies['GRD'] = array(2,',','.');      //  Euro
    $currencies['IEP'] = array(2,',','.');      //  Euro
    $currencies['ITL'] = array(2,',','.');      //  Euro
    $currencies['LUF'] = array(2,',','.');      //  Euro
    $currencies['NLG'] = array(2,',','.');      //  Euro
    $currencies['PTE'] = array(2,',','.');      //  Euro
    $currencies['GHC'] = array(2,'.',',');      //  Ghana, Cedi
    $currencies['GIP'] = array(2,'.',',');      //  Gibraltar Pound
    $currencies['GTQ'] = array(2,'.',',');      //  Guatemala, Quetzal
    $currencies['HNL'] = array(2,'.',',');      //  Honduras, Lempira
    $currencies['HKD'] = array(2,'.',',');      //  Hong Kong Dollar
    $currencies['HUF'] = array(0,'','.');     //  Hungary, Forint
    $currencies['ISK'] = array(0,'','.');     //  Iceland Krona
    $currencies['INR'] = array(2,'.',',');      //  Indian Rupee
    $currencies['IDR'] = array(2,',','.');      //  Indonesia, Rupiah
    $currencies['IRR'] = array(2,'.',',');      //  Iranian Rial
    $currencies['JMD'] = array(2,'.',',');      //  Jamaican Dollar
    $currencies['JPY'] = array(0,'',',');     //  Japan, Yen
    $currencies['JOD'] = array(3,'.',',');      //  Jordanian Dinar
    $currencies['KES'] = array(2,'.',',');      //  Kenyan Shilling
    $currencies['KWD'] = array(3,'.',',');      //  Kuwaiti Dinar
    $currencies['LVL'] = array(2,'.',',');      //  Latvian Lats
    $currencies['LBP'] = array(0,'',' ');     //  Lebanese Pound
    $currencies['LTL'] = array(2,',',' ');      //  Lithuanian Litas
    $currencies['MKD'] = array(2,'.',',');      //  Macedonia, Denar
    $currencies['MYR'] = array(2,'.',',');      //  Malaysian Ringgit
    $currencies['MTL'] = array(2,'.',',');      //  Maltese Lira
    $currencies['MUR'] = array(0,'',',');     //  Mauritius Rupee
    $currencies['MXN'] = array(2,'.',',');      //  Mexican Peso
    $currencies['MZM'] = array(2,',','.');      //  Mozambique Metical
    $currencies['NPR'] = array(2,'.',',');      //  Nepalese Rupee
    $currencies['ANG'] = array(2,'.',',');      //  Netherlands Antillian Guilder
    $currencies['ILS'] = array(2,'.',',');      //  New Israeli Shekel
    $currencies['TRY'] = array(2,'.',',');      //  New Turkish Lira
    $currencies['NZD'] = array(2,'.',',');      //  New Zealand Dollar
    $currencies['NOK'] = array(2,',','.');      //  Norwegian Krone
    $currencies['PKR'] = array(2,'.',',');      //  Pakistan Rupee
    $currencies['PEN'] = array(2,'.',',');      //  Peru, Nuevo Sol
    $currencies['UYU'] = array(2,',','.');      //  Peso Uruguayo
    $currencies['PHP'] = array(2,'.',',');      //  Philippine Peso
    $currencies['PLN'] = array(2,'.',' ');      //  Poland, Zloty
    $currencies['GBP'] = array(2,'.',',');      //  Pound Sterling
    $currencies['OMR'] = array(3,'.',',');      //  Rial Omani
    $currencies['RON'] = array(2,',','.');      //  Romania, New Leu
    $currencies['ROL'] = array(2,',','.');      //  Romania, Old Leu
    $currencies['RUB'] = array(2,',','.');      //  Russian Ruble
    $currencies['SAR'] = array(2,'.',',');      //  Saudi Riyal
    $currencies['SGD'] = array(2,'.',',');      //  Singapore Dollar
    $currencies['SKK'] = array(2,',',' ');      //  Slovak Koruna
    $currencies['SIT'] = array(2,',','.');      //  Slovenia, Tolar
    $currencies['ZAR'] = array(2,'.',' ');      //  South Africa, Rand
    $currencies['KRW'] = array(0,'',',');     //  South Korea, Won
    $currencies['SZL'] = array(2,'.',', ');     //  Swaziland, Lilangeni
    $currencies['SEK'] = array(2,',','.');      //  Swedish Krona
    $currencies['CHF'] = array(2,'.','\'');     //  Swiss Franc 
    $currencies['TZS'] = array(2,'.',',');      //  Tanzanian Shilling
    $currencies['THB'] = array(2,'.',',');      //  Thailand, Baht
    $currencies['TOP'] = array(2,'.',',');      //  Tonga, Paanga
    $currencies['AED'] = array(2,'.',',');      //  UAE Dirham
    $currencies['UAH'] = array(2,',',' ');      //  Ukraine, Hryvnia
    $currencies['USD'] = array(2,'.',',');      //  US Dollar
    $currencies['VUV'] = array(0,'',',');     //  Vanuatu, Vatu
    $currencies['VEF'] = array(2,',','.');      //  Venezuela Bolivares Fuertes
    $currencies['VEB'] = array(2,',','.');      //  Venezuela, Bolivar
    $currencies['VND'] = array(0,'','.');     //  Viet Nam, Dong
    $currencies['ZWD'] = array(2,'.',' ');      //  Zimbabwe Dollar

    if ($curr == "INR"){  
      return formatinr($floatcurr);
    } else {
      $default_num_decimals = ( isset($currencies[$curr]) ? $currencies[$curr][0] : 2 );
      $num_decimals = (intval($floatcurr) == $floatcurr) ? 0 : $default_num_decimals;
      $separator1 = ( isset($currencies[$curr]) ? $currencies[$curr][1] : '.' );
      $separator2 = ( isset($currencies[$curr]) ? $currencies[$curr][2] : '.' );
      return number_format($floatcurr, $num_decimals, $separator1, $separator2);
    }
  }

}

if ( ! function_exists('formatinr'))
{
  //CUSTOM FUNCTION TO GENERATE ##,##,###.##
  function formatinr($input){
    $dec = "";
    $pos = strpos($input, ".");
    if ($pos === false){
      //no decimals 
    } else {
      //decimals
      $dec = substr(round(substr($input,$pos),2),1);
      $input = substr($input,0,$pos);
    }
    $num = substr($input,-3); //get the last 3 digits
    $input = substr($input,0, -3); //omit the last 3 digits already stored in $num
    while(strlen($input) > 0) //loop the process - further get digits 2 by 2
    {
      $num = substr($input,-2).",".$num;
      $input = substr($input,0,-2);
    }
    return $num . $dec;
  }

}

if ( ! function_exists('prepare_for_mod_rewrite'))
{
  function prepare_for_mod_rewrite($str) {
    return str_replace('+', '-', (str_replace('&amp;','-',str_replace(array('/', '(', ')'),'-',str_replace('?','',str_replace(' ','\ ',str_replace(' ','-',strtolower(htmlspecialchars(str_replace(array('%', '"'),'',trim(stripslashes(rtrim($str)))))))))))));
  }
}

if ( ! function_exists('get_initial_date_by_period'))
{
  /**
   * Get first date of a period. For example first date of "1m" is date
   * that was 1 month ago
   *
   * @param  string  $period
   * @return string
   */
  function get_initial_date_by_period($period = '1m')
  {
    switch ($period) {
      case 'YTD':
        $initial_date = date('Y') . '-01-01';
        break;
      case '1y':
        $initial_date = date('Y-m-d', strtotime('-1 year'));
        break;
      case '6m':
        $initial_date = date('Y-m-d', strtotime('-6 months'));
        break;
      case '3m':
        $initial_date = date('Y-m-d', strtotime('-3 months'));
        break;
      case '1w':
        $initial_date = date('Y-m-d', strtotime('-1 week'));
        break;
      case '1m':
      default:
        $initial_date = date('Y-m-d', strtotime('-1 month'));
        break;
    }

    return $initial_date;
  }
}
