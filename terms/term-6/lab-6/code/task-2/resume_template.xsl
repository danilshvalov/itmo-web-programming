<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:template match="resume">
    Кандидаты, возраст которых меньше 32 лет:
    <xsl:for-each select="candidate/Age[number(.) &lt; 32]">
      <xsl:value-of select=".."/>
    </xsl:for-each>

    Кандидаты, возраст которых больше или равен 33 годам:
    <xsl:for-each select="candidate/Age[number(.) &gt;= 33]">
      <xsl:value-of select=".."/>
    </xsl:for-each>
  </xsl:template>
</xsl:stylesheet>
