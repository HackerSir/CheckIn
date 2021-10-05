<?php

namespace App\DataTables\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Contracts\DataTableScope;

class QrcodeQrcodeSetScope implements DataTableScope
{
    /**
     * @var int
     */
    private $qrcodeSetId;

    /**
     * QrcodeQrcodeSetScope constructor.
     *
     * @param  int  $qrcodeSetId
     */
    public function __construct($qrcodeSetId)
    {
        $this->qrcodeSetId = $qrcodeSetId;
    }

    /**
     * Apply a query scope.
     *
     * @param  \Illuminate\Database\Query\Builder|Builder  $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->where('qrcode_set_id', $this->qrcodeSetId);
    }
}
