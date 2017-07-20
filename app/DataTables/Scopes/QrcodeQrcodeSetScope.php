<?php

namespace App\DataTables\Scopes;

use Yajra\Datatables\Contracts\DataTableScopeContract;

class QrcodeQrcodeSetScope implements DataTableScopeContract
{
    /**
     * @var int
     */
    private $qrcodeSetId;

    /**
     * QrcodeQrcodeSetScope constructor.
     * @param int $qrcodeSetId
     */
    public function __construct($qrcodeSetId)
    {
        $this->qrcodeSetId = $qrcodeSetId;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        return $query->where('qrcode_set_id', $this->qrcodeSetId);
    }
}
