<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:template match="lessons">
    Второе занятие:
    <xsl:value-of select="lesson[position()=2]"/>
    Предпоследнее занятие:
    <xsl:value-of select="lesson[position()=last()-1]"/>
    Количество занятий: <xsl:value-of select="count(*)"/>
    Количество академических часов третьего занятия:
    <xsl:value-of select="lesson[position()=3]/AcademicHours"/>
  </xsl:template>
</xsl:stylesheet>
