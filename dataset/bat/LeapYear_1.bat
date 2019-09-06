@ECHO OFF

REM Check command line parameter
IF NOT [%2]==[]   GOTO Syntax
IF     [%1]==[?]  GOTO Syntax
IF     [%1]==[/?] GOTO Syntax
IF     [%1]==[-?] GOTO Syntax
IF NOT [%1]==[]   GOTO Year

REM Check if BATCHMAN.COM is available
BATCHMAN MONTH
IF NOT ERRORLEVEL 1 GOTO Syntax

REM If no year specified: get current year as errorlevel offset with -1980
BATCHMAN YEAR

REM "Convert" errorlevel to year
SET Year=1980
IF ERRORLEVEL   1 SET Year=1981
IF ERRORLEVEL   2 SET Year=1982
IF ERRORLEVEL   3 SET Year=1983
IF ERRORLEVEL   4 SET Year=1984
IF ERRORLEVEL   5 SET Year=1985
IF ERRORLEVEL   6 SET Year=1986
IF ERRORLEVEL   7 SET Year=1987
IF ERRORLEVEL   8 SET Year=1988
IF ERRORLEVEL   9 SET Year=1989
IF ERRORLEVEL  10 SET Year=1990
IF ERRORLEVEL  11 SET Year=1991
IF ERRORLEVEL  12 SET Year=1992
IF ERRORLEVEL  13 SET Year=1993
IF ERRORLEVEL  14 SET Year=1994
IF ERRORLEVEL  15 SET Year=1995
IF ERRORLEVEL  16 SET Year=1996
IF ERRORLEVEL  17 SET Year=1997
IF ERRORLEVEL  18 SET Year=1998
IF ERRORLEVEL  19 SET Year=1999
IF ERRORLEVEL  20 SET Year=2000
IF ERRORLEVEL  21 SET Year=2001
IF ERRORLEVEL  22 SET Year=2002
IF ERRORLEVEL  23 SET Year=2003
IF ERRORLEVEL  24 SET Year=2004
IF ERRORLEVEL  25 SET Year=2005
IF ERRORLEVEL  26 SET Year=2006
IF ERRORLEVEL  27 SET Year=2007
IF ERRORLEVEL  28 SET Year=2008
IF ERRORLEVEL  29 SET Year=2009
IF ERRORLEVEL  30 SET Year=2010
IF ERRORLEVEL  31 SET Year=2011
IF ERRORLEVEL  32 SET Year=2012
IF ERRORLEVEL  33 SET Year=2013
IF ERRORLEVEL  34 SET Year=2014
IF ERRORLEVEL  35 SET Year=2015
IF ERRORLEVEL  36 SET Year=2016
IF ERRORLEVEL  37 SET Year=2017
IF ERRORLEVEL  38 SET Year=2018
IF ERRORLEVEL  39 SET Year=2019
IF ERRORLEVEL  40 SET Year=2020
IF ERRORLEVEL  41 SET Year=2021
IF ERRORLEVEL  42 SET Year=2022
IF ERRORLEVEL  43 SET Year=2023
IF ERRORLEVEL  44 SET Year=2024
IF ERRORLEVEL  45 SET Year=2025
IF ERRORLEVEL  46 SET Year=2026
IF ERRORLEVEL  47 SET Year=2027
IF ERRORLEVEL  48 SET Year=2028
IF ERRORLEVEL  49 SET Year=2029
IF ERRORLEVEL  50 SET Year=2030
IF ERRORLEVEL  51 SET Year=2031
IF ERRORLEVEL  52 SET Year=2032
IF ERRORLEVEL  53 SET Year=2033
IF ERRORLEVEL  54 SET Year=2034
IF ERRORLEVEL  55 SET Year=2035
IF ERRORLEVEL  56 SET Year=2036
IF ERRORLEVEL  57 SET Year=2037
IF ERRORLEVEL  58 SET Year=2038
IF ERRORLEVEL  59 SET Year=2039
IF ERRORLEVEL  60 SET Year=2040
IF ERRORLEVEL  61 SET Year=2041
IF ERRORLEVEL  62 SET Year=2042
IF ERRORLEVEL  63 SET Year=2043
IF ERRORLEVEL  64 SET Year=2044
IF ERRORLEVEL  65 SET Year=2045
IF ERRORLEVEL  66 SET Year=2046
IF ERRORLEVEL  67 SET Year=2047
IF ERRORLEVEL  68 SET Year=2048
IF ERRORLEVEL  69 SET Year=2049
IF ERRORLEVEL  70 SET Year=2050
IF ERRORLEVEL  71 SET Year=2051
IF ERRORLEVEL  72 SET Year=2052
IF ERRORLEVEL  73 SET Year=2053
IF ERRORLEVEL  74 SET Year=2054
IF ERRORLEVEL  75 SET Year=2055
IF ERRORLEVEL  76 SET Year=2056
IF ERRORLEVEL  77 SET Year=2057
IF ERRORLEVEL  78 SET Year=2058
IF ERRORLEVEL  79 SET Year=2059
IF ERRORLEVEL  80 SET Year=2060
IF ERRORLEVEL  81 SET Year=2061
IF ERRORLEVEL  82 SET Year=2062
IF ERRORLEVEL  83 SET Year=2063
IF ERRORLEVEL  84 SET Year=2064
IF ERRORLEVEL  85 SET Year=2065
IF ERRORLEVEL  86 SET Year=2066
IF ERRORLEVEL  87 SET Year=2067
IF ERRORLEVEL  88 SET Year=2068
IF ERRORLEVEL  89 SET Year=2069
IF ERRORLEVEL  90 SET Year=2070
IF ERRORLEVEL  91 SET Year=2071
IF ERRORLEVEL  92 SET Year=2072
IF ERRORLEVEL  93 SET Year=2073
IF ERRORLEVEL  94 SET Year=2074
IF ERRORLEVEL  95 SET Year=2075
IF ERRORLEVEL  96 SET Year=2076
IF ERRORLEVEL  97 SET Year=2077
IF ERRORLEVEL  98 SET Year=2078
IF ERRORLEVEL  99 SET Year=2079
IF ERRORLEVEL 100 SET Year=2080
IF ERRORLEVEL 101 SET Year=2081
IF ERRORLEVEL 102 SET Year=2082
IF ERRORLEVEL 103 SET Year=2083
IF ERRORLEVEL 104 SET Year=2084
IF ERRORLEVEL 105 SET Year=2085
IF ERRORLEVEL 106 SET Year=2086
IF ERRORLEVEL 107 SET Year=2087
IF ERRORLEVEL 108 SET Year=2088
IF ERRORLEVEL 109 SET Year=2089
IF ERRORLEVEL 110 SET Year=2090
IF ERRORLEVEL 111 SET Year=2091
IF ERRORLEVEL 112 SET Year=2092
IF ERRORLEVEL 113 SET Year=2093
IF ERRORLEVEL 114 SET Year=2094
IF ERRORLEVEL 115 SET Year=2095
IF ERRORLEVEL 116 SET Year=2096
IF ERRORLEVEL 117 SET Year=2097
IF ERRORLEVEL 118 SET Year=2098
IF ERRORLEVEL 119 SET Year=2099
IF ERRORLEVEL 120 SET Year=2100
IF ERRORLEVEL 121 SET Year=2101
IF ERRORLEVEL 122 SET Year=2102
IF ERRORLEVEL 123 SET Year=2103
IF ERRORLEVEL 124 SET Year=2104
IF ERRORLEVEL 125 SET Year=2105
IF ERRORLEVEL 126 SET Year=2106
IF ERRORLEVEL 127 SET Year=2107
IF ERRORLEVEL 128 SET Year=2108
IF ERRORLEVEL 129 SET Year=2109
IF ERRORLEVEL 130 SET Year=2110
IF ERRORLEVEL 131 SET Year=2111
IF ERRORLEVEL 132 SET Year=2112
IF ERRORLEVEL 133 SET Year=2113
IF ERRORLEVEL 134 SET Year=2114
IF ERRORLEVEL 135 SET Year=2115
IF ERRORLEVEL 136 SET Year=2116
IF ERRORLEVEL 137 SET Year=2117
IF ERRORLEVEL 138 SET Year=2118
IF ERRORLEVEL 139 SET Year=2119
IF ERRORLEVEL 140 SET Year=2120
IF ERRORLEVEL 141 SET Year=2121
IF ERRORLEVEL 142 SET Year=2122
IF ERRORLEVEL 143 SET Year=2123
IF ERRORLEVEL 144 SET Year=2124
IF ERRORLEVEL 145 SET Year=2125
IF ERRORLEVEL 146 SET Year=2126
IF ERRORLEVEL 147 SET Year=2127
IF ERRORLEVEL 148 SET Year=2128
IF ERRORLEVEL 149 SET Year=2129
IF ERRORLEVEL 150 SET Year=2130
IF ERRORLEVEL 151 SET Year=2131
IF ERRORLEVEL 152 SET Year=2132
IF ERRORLEVEL 153 SET Year=2133
IF ERRORLEVEL 154 SET Year=2134
IF ERRORLEVEL 155 SET Year=2135
IF ERRORLEVEL 156 SET Year=2136
IF ERRORLEVEL 157 SET Year=2137
IF ERRORLEVEL 158 SET Year=2138
IF ERRORLEVEL 159 SET Year=2139
IF ERRORLEVEL 160 SET Year=2140
IF ERRORLEVEL 161 SET Year=2141
IF ERRORLEVEL 162 SET Year=2142
IF ERRORLEVEL 163 SET Year=2143
IF ERRORLEVEL 164 SET Year=2144
IF ERRORLEVEL 165 SET Year=2145
IF ERRORLEVEL 166 SET Year=2146
IF ERRORLEVEL 167 SET Year=2147
IF ERRORLEVEL 168 SET Year=2148
IF ERRORLEVEL 169 SET Year=2149
IF ERRORLEVEL 170 SET Year=2150
IF ERRORLEVEL 171 SET Year=2151
IF ERRORLEVEL 172 SET Year=2152
IF ERRORLEVEL 173 SET Year=2153
IF ERRORLEVEL 174 SET Year=2154
IF ERRORLEVEL 175 SET Year=2155
IF ERRORLEVEL 176 SET Year=2156
IF ERRORLEVEL 177 SET Year=2157
IF ERRORLEVEL 178 SET Year=2158
IF ERRORLEVEL 179 SET Year=2159
IF ERRORLEVEL 180 SET Year=2160
IF ERRORLEVEL 181 SET Year=2161
IF ERRORLEVEL 182 SET Year=2162
IF ERRORLEVEL 183 SET Year=2163
IF ERRORLEVEL 184 SET Year=2164
IF ERRORLEVEL 185 SET Year=2165
IF ERRORLEVEL 186 SET Year=2166
IF ERRORLEVEL 187 SET Year=2167
IF ERRORLEVEL 188 SET Year=2168
IF ERRORLEVEL 189 SET Year=2169
IF ERRORLEVEL 190 SET Year=2170
IF ERRORLEVEL 191 SET Year=2171
IF ERRORLEVEL 192 SET Year=2172
IF ERRORLEVEL 193 SET Year=2173
IF ERRORLEVEL 194 SET Year=2174
IF ERRORLEVEL 195 SET Year=2175
IF ERRORLEVEL 196 SET Year=2176
IF ERRORLEVEL 197 SET Year=2177
IF ERRORLEVEL 198 SET Year=2178
IF ERRORLEVEL 199 SET Year=2179
GOTO LeapYear

:Year
REM Reset LY for leap years
FOR %%A IN (%1) DO SET Year=%%A

:LeapYear
SET LY=is NOT
FOR %%A IN (1980 1984 1988 1992 1996 2000 2004 2008 2012 2016) DO IF %Year%==%%A SET LY=IS
FOR %%A IN (2020 2024 2028 2032 2036 2040 2044 2048 2052 2056) DO IF %Year%==%%A SET LY=IS
FOR %%A IN (2060 2064 2068 2072 2076 2080 2084 2088 2092 2096) DO IF %Year%==%%A SET LY=IS
REM 2100 is NOT a leap year
FOR %%A IN (2104 2108 2112 2116 2120 2124 2128 2132 2136 2140) DO IF %Year%==%%A SET LY=IS
FOR %%A IN (2144 2148 2152 2156 2160 2164 2168 2172 2176) DO IF %Year%==%%A SET LY=IS

REM Set variable LeapYear true or false
SET LeapYear=0
IF "%LY%"=="IS" SET LeapYear=1

REM Display the result
ECHO %Year% %LY% a leap year

REM Done
GOTO End

:Syntax
ECHO.
ECHO LeapYear.bat,  Version 2.00 for DOS
ECHO Check if the specified or current year is a leap year
ECHO.
ECHO Usage:    LEAPYEAR  [ year ]
ECHO.
ECHO Where:    "year" is a number from 1980 .. 2179
ECHO           Default is the current year
ECHO.
ECHO Returns:  Screen output plus environment variable %%LeapYear%%
ECHO.
ECHO This batch file uses BATCHMAN by Michael Mefford to retrieve the current year
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:End
REM Clean up temporary variables
SET Year=
SET LY=