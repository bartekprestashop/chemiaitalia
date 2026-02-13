<?php
/**
 * Copyright 2024 DPD Polska Sp. z o.o.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the EUPL-1.2 or later.
 * You may not use this work except in compliance with the Licence.
 *
 * You may obtain a copy of the Licence at:
 * https://joinup.ec.europa.eu/software/page/eupl
 * It is also bundled with this package in the file LICENSE.txt
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the Licence is distributed on an AS IS basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the Licence for the specific language governing permissions
 * and limitations under the Licence.
 *
 * @author    DPD Polska Sp. z o.o.
 * @copyright 2024 DPD Polska Sp. z o.o.
 * @license   https://joinup.ec.europa.eu/software/page/eupl
 */

namespace DpdShipping\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Config
{
    public const PL_CONST = 'PL';
    public const PASSWORD_HIDDEN = 'HIDDEN';
    public const DPD_INFO_SERVICES_LIVE = 'https://dpdinfoservices.dpd.com.pl/DPDInfoServicesObjEventsService/DPDInfoServicesObjEvents?wsdl';
    public const DPD_API_URL_LIVE = 'https://dpdservices.dpd.com.pl/DPDPackageObjServicesService/DPDPackageObjServices?wsdl';
    public const DPD_API_URL_DEMO = 'https://dpdservicesdemo.dpd.com.pl/DPDPackageObjServicesService/DPDPackageObjServices?wsdl';
    public const DPD_STANDARD = 'DPD_STANDARD';
    public const DPD_STANDARD_COD = 'DPD_STANDARD_COD';
    public const DPD_PICKUP = 'DPD_PICKUP';
    public const DPD_PICKUP_COD = 'DPD_PICKUP_COD';

    public const DPD_PICKUP_MAP_URL_WITH_FILTERS = 'DPD_PICKUP_MAP_URL_WITH_FILTERS';
    public const DPD_PICKUP_COD_MAP_URL_WITH_FILTERS = 'DPD_PICKUP_COD_MAP_URL_WITH_FILTERS';
    public const DPD_TRACKING_URL = 'https://tracktrace.dpd.com.pl/parcelDetails?typ=1&p1=@';

    public const DPD_PUDO_WS_URL = 'https://mypudo.dpd.com.pl/api/pudo/details?pudoId=%s&key=4444';
    public const PICKUP_MAP_BASE_URL = '//pudofinder.dpd.com.pl/widget?key=1ae3418e27627ab52bebdcc1a958fa04';
}
