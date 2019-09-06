﻿function Get-CommonParameter
{
     param
     (
         [Object]
         $BoundParameters = $null
     )

    $commonParams = ''
    
    if ($BoundParameters)
    {
        if ($BoundParameters['Verbose'] -and $($BoundParameters['Verbose'].ToString() -eq 'True'))
        {
            $commonParams += ' -Verbose'
        }
        if ($BoundParameters['Debug'] -and $($BoundParameters['Debug'].ToString() -eq 'True'))
        {
            $commonParams += ' -Debug'
        }
        if ($BoundParameters['ErrorAction'])
        {
            $commonParams += " -ErrorAction $($BoundParameters['ErrorAction'].ToString())"
        }
        if ($BoundParameters['InformationAction'])
        {
            $commonParams += " -InformationAction $($BoundParameters['InformationAction'].ToString())"
        }
        if ($BoundParameters['WarningAction'])
        {
            $commonParams += " -WarningAction $($BoundParameters['WarningAction'].ToString())"
        }
    }

    $commonParams += ' -Context $context'

    return $commonParams
}