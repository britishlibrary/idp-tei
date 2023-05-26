<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    
    <!-- process only the <head> element -->
    
    <xsl:template match="TEI.2/teiHeader"> </xsl:template>
    <xsl:template match="TEI.2/text/head/@intro">
        <xsl:apply-templates></xsl:apply-templates>
    </xsl:template>
    <xsl:template match="TEI.2/text/body"> </xsl:template>
    
    <!-- formatting -->
    
    <xsl:template match="p">
        <p><xsl:apply-templates></xsl:apply-templates></p>
    </xsl:template>
    <xsl:template match="p/q">
        <span class="bibit">
            <xsl:apply-templates></xsl:apply-templates>
        </span>
    </xsl:template>
    <xsl:template match="p/locus">
        <xsl:value-of select="."></xsl:value-of>
    </xsl:template>
    <xsl:template match="title">
        <span class="bibit">
            <xsl:value-of select="."></xsl:value-of>
        </span>
    </xsl:template>
    <xsl:template match="ref">
        <xsl:choose>
            <xsl:when test="normalize-space(.)">
                <xsl:value-of select="@target"></xsl:value-of>: <xsl:value-of select="."
                ></xsl:value-of>
            </xsl:when>
            <xsl:otherwise>
                <xsl:value-of select="@target"></xsl:value-of>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
    <xsl:template match="term">
        <span class="bibit">
            <xsl:value-of select="."></xsl:value-of>
        </span>
    </xsl:template>
    <xsl:template match="name">
        <xsl:value-of select="."></xsl:value-of>
    </xsl:template>
    <xsl:template match="q">
        <small>
            <xsl:apply-templates></xsl:apply-templates>
        </small>
        <br></br>
    </xsl:template>
    <xsl:template match="link">
        <xsl:element name="a">
            <xsl:attribute name="href">
                <xsl:value-of select="@url"></xsl:value-of>
            </xsl:attribute>
            <xsl:attribute name="target">_blank</xsl:attribute>
            <xsl:apply-templates> </xsl:apply-templates>
        </xsl:element>
    </xsl:template>
    <xsl:template match="q/locus"> (<xsl:value-of select="."></xsl:value-of>) </xsl:template>
    <xsl:template match="p/q/locus"> (<xsl:value-of select="."></xsl:value-of>) </xsl:template>
    <xsl:template match="ref">
        <xsl:element name="a">
            <xsl:attribute name="href">/database/bibliography.a4d?shortref=<xsl:value-of
                select="@target"></xsl:value-of></xsl:attribute>
            <xsl:attribute name="onClick"
                >popUpII(this.href,'elastic',400,600,'bibliographywin');return false;</xsl:attribute>
            <xsl:choose>
                <xsl:when test="normalize-space(.)">
                    <xsl:value-of select="@target"></xsl:value-of>: <xsl:value-of select="."
                        ></xsl:value-of>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="@target"></xsl:value-of>
                </xsl:otherwise>
            </xsl:choose>
        </xsl:element>
    </xsl:template>
    <xsl:template match="note[@type='footnote']">
        <xsl:choose>
            <xsl:when test="@n">
                <span class="smaller">[note <xsl:value-of select="@n"></xsl:value-of>: <xsl:value-of
                        select="."></xsl:value-of>]</span>
            </xsl:when>
            <xsl:otherwise>
                <span class="smaller">[note: <xsl:value-of select="."></xsl:value-of>]</span>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template match="a">
        <xsl:copy-of select="."></xsl:copy-of>
    </xsl:template>
    
    
    <!-- Line and page breaks (line and page numbers are optional for lb, lg, l and pb): -->
    
    <xsl:template match="lb">
        <xsl:if test="@n">
            <xsl:text>l.</xsl:text>
            <xsl:value-of select="@n"></xsl:value-of>
            <xsl:text>: </xsl:text>
        </xsl:if>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="lg">
        <xsl:element name="p">
            <xsl:apply-templates></xsl:apply-templates>
        </xsl:element>
    </xsl:template>
    <xsl:template match="l">
        <xsl:if test="@n">
            <xsl:text>l.</xsl:text>
            <xsl:value-of select="@n"></xsl:value-of>
            <xsl:text>: </xsl:text>
        </xsl:if>
        <xsl:apply-templates></xsl:apply-templates>
        <xsl:element name="br"></xsl:element>
    </xsl:template>
    <xsl:template match="pb">
        <xsl:element name="p">
            <xsl:if test="@n">
                <xsl:text>(</xsl:text>
                <xsl:value-of select="@n"></xsl:value-of>
                <xsl:text>) </xsl:text>
            </xsl:if>
            <xsl:value-of select="."></xsl:value-of>
        </xsl:element>
    </xsl:template>
</xsl:stylesheet>
