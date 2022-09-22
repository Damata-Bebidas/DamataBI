Sub importar_txt()
'
' importar_txt Macro
'
' Atalho do teclado: Ctrl+Shift+A
'
    Dim linha As Long, valor As Double, data, datatxt, valortxt, caminho As String, centavos, real, dia, mes, ano, w As Integer
    
    cabecalhos = Array("numeroDocumento ", "NB ", "valor ", "vencimento ", "danfe ", "nome ", "pj_pf ", "cpf ", "end ", "bairro ", "cidade ", "uf ", "cep ")
    
    caminho = ThisWorkbook.Path
    
    Planilha1.Select
    Cells.Select
    Selection.ClearContents
    Range("A1").Select
    
    Application.CutCopyMode = False
    With ActiveSheet.QueryTables.Add(Connection:= _
        "TEXT;" & caminho & "\safra.txt", Destination:=Range( _
        "$A$1"))
        .Name = "B4221483_1"
        .FieldNames = True
        .RowNumbers = False
        .FillAdjacentFormulas = False
        .PreserveFormatting = True
        .RefreshOnFileOpen = False
        .RefreshStyle = xlInsertDeleteCells
        .SavePassword = False
        .SaveData = True
        .RefreshPeriod = False
        .TextFilePromptOnRefresh = False
        .TextFilePlatform = 10000
        .TextFileStartRow = 1
        .TextFileParseType = xlFixedWidth
        .TextFileTextQualifier = xlTextQualifierDoubleQuote
        .TextFileConsecutiveDelimiter = False
        .TextFileTabDelimiter = True
        .TextFileSemicolonDelimiter = False
        .TextFileCommaDelimiter = False
        .TextFileSpaceDelimiter = False
        .TextFileColumnDataTypes = Array(2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2)
        .TextFileFixedColumnWidths = Array(33, 55, 16, 174, 30, 4, 14, 23, 15, 10, 9)
        .TextFileTrailingMinusNumbers = True
        .Refresh BackgroundQuery:=False
    End With
    
    linha = 2
    
    Do While Planilha1.Cells(linha, 2) <> ""
        Planilha1.Cells(linha, 13) = "'" & Left(Planilha1.Cells(linha, 4), 34) 'CONVERTER
        valortxt = Right(Planilha1.Cells(linha, 13), 13) 'VALOR
        centavos = Right(valortxt, 2)
        real = Mid(valortxt, 1, Len(valortxt) - 2)
        valor = real & "," & centavos
        Planilha1.Cells(linha, 14) = valor
        
        datatxt = Mid(Planilha1.Cells(linha, 13), 16, 6) 'DATA
        dia = Left(datatxt, 2)
        mes = Mid(datatxt, 3, 2)
        ano = "20" & Right(datatxt, 2)
        data = "'" & dia & "/" & mes & "/" & ano
        Planilha1.Cells(linha, 15) = data 'DATA
        Planilha1.Cells(linha, 16) = Mid(Planilha1.Cells(linha, 13), 8, 6) 'DANFE
        Planilha1.Cells(linha, 13) = Right(Left(Planilha1.Cells(linha, 4), 129), 14) 'CONVERTER
        
        If Len(Planilha1.Cells(linha, 13)) > 11 Then
            Planilha1.Cells(linha, 17) = "J"
        Else
            Planilha1.Cells(linha, 17) = "F"
        End If
        
        Planilha1.Cells(linha, 18) = "422" & Right(Planilha1.Cells(linha, 2), 9) 'Doc
        Planilha1.Cells(linha, 19) = Planilha1.Cells(linha, 11)  'nb
        Planilha1.Cells(linha, 20) = Planilha1.Cells(linha, 14)  'valor
        Planilha1.Cells(linha, 21) = Planilha1.Cells(linha, 15)  'vencimento
        Planilha1.Cells(linha, 22) = Planilha1.Cells(linha, 16)  'danfe
        Planilha1.Cells(linha, 23) = Trim(Mid(Planilha1.Cells(linha, 4), 130, 40)) 'Nome
        Planilha1.Cells(linha, 24) = Planilha1.Cells(linha, 17)  'tipo pessoa
        Planilha1.Cells(linha, 25) = Planilha1.Cells(linha, 13)  'cpf
        Planilha1.Cells(linha, 26) = Planilha1.Cells(linha, 5) & ", " & Planilha1.Cells(linha, 6)   'end
        Planilha1.Cells(linha, 27) = Left(Planilha1.Cells(linha, 7), 10) 'bairro
        Planilha1.Cells(linha, 28) = Mid(Planilha1.Cells(linha, 8), 9, Len(Planilha1.Cells(linha, 8)))  'cidade
        Planilha1.Cells(linha, 29) = Left(Planilha1.Cells(linha, 9), 2) 'UF
        Planilha1.Cells(linha, 30) = Left(Planilha1.Cells(linha, 8), 8) 'cep
        
        
        If WorksheetFunction.IsText(Planilha1.Cells(linha, 21)) Then
            Planilha1.Cells(linha, 21) = DateValue(Planilha1.Cells(linha, 21))   'se erro
        End If
        
        linha = linha + 1
    Loop
    
    For w = 0 To UBound(cabecalhos, 1) Step 1
        Planilha1.Cells(1, w + 18) = cabecalhos(w)
    Next w
    
    For w = 1 To 17 Step 1
        Columns(1).Delete
    Next w
    
    Cells.Select
    Cells.EntireColumn.AutoFit
    Columns("A:A").Select
    Selection.NumberFormat = "0"
    Columns("C:C").Select
    Selection.Style = "Currency"
    Columns("D:D").Select
    Selection.NumberFormat = "dd/mm/yyyy"
    Columns("H:H").Select
    Selection.NumberFormat = "0"
    Range("A1").Select
    
    linha = 2
    Do While Planilha1.Cells(linha, 8) <> ""
        Select Case Len(Planilha1.Cells(linha, 8))
            Case Is >= 11
                Planilha1.Cells(linha, 8) = "'" & Planilha1.Cells(linha, 8)  'cpf"
            Case 10
                Planilha1.Cells(linha, 8) = "'0" & Planilha1.Cells(linha, 8)  'cpf
            Case 9
                Planilha1.Cells(linha, 8) = "'00" & Planilha1.Cells(linha, 8)  'cpf
            Case 8
                Planilha1.Cells(linha, 8) = "'000" & Planilha1.Cells(linha, 8)  'cpf
            Case 7
                Planilha1.Cells(linha, 8) = "'0000" & Planilha1.Cells(linha, 8)  'cpf
            Case 6
                Planilha1.Cells(linha, 8) = "'00000" & Planilha1.Cells(linha, 8)  'cpf
            Case 5
                Planilha1.Cells(linha, 8) = "'000000" & Planilha1.Cells(linha, 8)  'cpf
            Case 4
                 Planilha1.Cells(linha, 8) = "'0000000" & Planilha1.Cells(linha, 8)  'cpf
            Case 3
                 Planilha1.Cells(linha, 8) = "'00000000" & Planilha1.Cells(linha, 8)  'cpf
            Case 2
                Planilha1.Cells(linha, 8) = "'000000000" & Planilha1.Cells(linha, 8)  'cpf
            Case 1
                Planilha1.Cells(linha, 8) = "'0000000000" & Planilha1.Cells(linha, 8)  'cpf
        End Select
        linha = linha + 1
    Loop
    
    ThisWorkbook.Save
    ActiveWorkbook.SaveAs Filename:=caminho & "\Boletos.xml", FileFormat:= _
        xlXMLSpreadsheet, ReadOnlyRecommended:=False, CreateBackup:=False

End Sub
