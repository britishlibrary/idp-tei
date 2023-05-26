<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>
    <xsl:param name="catNumber" select="'10'"/>
    <xsl:param name="shortRef" select="'Thilo_1985'"/>
    <xsl:template match="teiHeader"/>
    <xsl:template match="head"/>
    <xsl:template match="msDescription">
        <xsl:choose>
            <xsl:when test="attribute::n=$catNumber">
                <span class="bibbold">
                    <xsl:element name="a">
                        <xsl:attribute name="href">oo_cat.a4d?shortref=<xsl:value-of select="$shortRef"/>&amp;catno=<xsl:value-of select="@n"/></xsl:attribute>
                        <xsl:attribute name="Title">View Full Catalogue</xsl:attribute>
                        <xsl:value-of select="$shortRef"/>
                    </xsl:element>
                    <xsl:text>: </xsl:text>
                    <xsl:value-of select="@n"/>
                </span>
            </xsl:when>
            <xsl:otherwise> </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>
