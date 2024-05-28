<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:key name="professorId" match="university/professors/professor" use="@id"/>
  <xsl:attribute-set name="professor-style">
    <xsl:attribute name="id">
      <xsl:value-of select="@id"/>
    </xsl:attribute>
  </xsl:attribute-set>
  <xsl:attribute-set name="professor-email">
    <xsl:attribute name="href">
      mailto:<xsl:value-of select="email"/>
    </xsl:attribute>
  </xsl:attribute-set>
  <xsl:attribute-set name="course-professor-anchor-style">
    <xsl:attribute name="href">
      #<xsl:value-of select="@professorId"/>
    </xsl:attribute>
  </xsl:attribute-set>
  <xsl:template match="university">
    <html>
      <head>
        <link rel="stylesheet" type="text/css" href="university.css"/>
      </head>
      <body>
        <h3>Информация о курсах</h3>
        <table>
          <tr>
            <th>Название</th>
            <th>Номер семестра</th>
            <th>Количество академических часов</th>
            <th>Тип контроля</th>
            <th>Формат проведения</th>
            <th>Преподаватель</th>
          </tr>
          <xsl:for-each select="courses/course">
            <xsl:sort select="semester" order="ascending"/>
            <tr>
              <td>
                <xsl:value-of select="name"/>
              </td>
              <td>
                <xsl:value-of select="semester"/>
              </td>
              <td>
                <xsl:value-of select="academic_hours"/>
              </td>
              <td>
                <xsl:value-of select="control_type"/>
              </td>
              <td>
                <xsl:value-of select="format"/>
              </td>
              <td>
                <a xsl:use-attribute-sets="course-professor-anchor-style">
                  <xsl:value-of select="key('professorId', @professorId)/last_name"/>
                </a>
              </td>
            </tr>
          </xsl:for-each>
        </table>
        <h3>Информация о преподавателях</h3>
        <table>
          <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Квалификация</th>
            <th>Электронная почта</th>
          </tr>
          <xsl:for-each select="professors/professor">
            <tr xsl:use-attribute-sets="professor-style">
              <td>
                <xsl:value-of select="last_name"/>
              </td>
              <td>
                <xsl:value-of select="first_name"/>
              </td>
              <td>
                <xsl:value-of select="patronymic"/>
              </td>
              <td>
                <xsl:value-of select="qualification"/>
              </td>
              <td>
                <a xsl:use-attribute-sets="professor-email">
                  <xsl:value-of select="email"/>
                </a>
              </td>
            </tr>
          </xsl:for-each>
        </table>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
