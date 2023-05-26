<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:import href="entry_cat.xsl"></xsl:import>
    <xsl:output method="html"></xsl:output>
    <xsl:param name="catalogueNumber" select="2"></xsl:param>
    <xsl:template match="teiHeader"></xsl:template>
    <xsl:template match="head"></xsl:template>
    <xsl:template match="msDescription">
        <xsl:choose>
            <xsl:when test="@n=$catalogueNumber">
                <span class="notheader">
                    <xsl:value-of select="@n"></xsl:value-of>
                </span>
                <br></br>
                <xsl:for-each select="msIdentifier/idno">
                    <xsl:if test="@type='current'">
                        <xsl:element name="a">
                            <xsl:attribute name="href">oo_loader.a4d?pm=<xsl:value-of select="."
                                ></xsl:value-of></xsl:attribute>
                            <xsl:value-of select="."></xsl:value-of>
                        </xsl:element>
                        <br></br>
                    </xsl:if>
                    <xsl:if test="@type='old'">
                        <xsl:value-of select="."></xsl:value-of>
                        <br></br>
                    </xsl:if>
                </xsl:for-each>
                <br></br>
                <xsl:apply-imports></xsl:apply-imports>
            </xsl:when>
            <xsl:otherwise> </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>
