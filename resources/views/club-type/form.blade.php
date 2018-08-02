{{ bs()->formGroup(bs()->text('name')->required()->placeholder('如：學藝性'))->label('名稱')->showAsRow() }}
{{ bs()->formGroup(bs()->input('color', 'color'))->label('標籤顏色')->showAsRow() }}
{{ bs()->formGroup(bs()->checkBox('is_counted', '列入抽獎集點'))->showAsRow('no_label') }}
