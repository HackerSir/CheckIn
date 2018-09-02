{{ bs()->formGroup(bs()->text('nid')->required()->placeholder('如：M0402935'))->label('學號')->showAsRow() }}
{{ bs()->formGroup(bs()->text('name')->required()->placeholder('如：許展源'))->label('姓名')->showAsRow() }}
{{ bs()->formGroup(bs()->text('class')->placeholder('如：資訊碩二'))->label('系級')->showAsRow() }}
