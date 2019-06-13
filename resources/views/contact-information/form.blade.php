{{ bs()->formGroup(bs()->text('phone'))->label('電話')->showAsRow() }}
{{ bs()->formGroup(bs()->text('email'))->label('信箱')->showAsRow() }}
{{ bs()->formGroup(bs()->text('facebook'))->label('Facebook')->helpText('請填寫個人檔案連結（個人頁面網址）')->showAsRow() }}
{{ bs()->formGroup(bs()->text('line'))->label('LINE ID')->showAsRow() }}
