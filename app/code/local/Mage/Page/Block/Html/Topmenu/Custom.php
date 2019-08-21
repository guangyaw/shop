<?php
class Mage_Page_Block_Html_Topmenu_Custom extends Mage_Core_Block_Template
{
    /**
     * Top menu data tree
     *
     * @var Varien_Data_Tree_Node
     */
    protected $_menu;
	
	 /**
     * Current entity key
     *
     * @var string|int
     */
    protected $_currentEntityKey;

    /**
     * Init top menu tree structure
     */
    public function _construct()
    {
        $this->_menu = new Varien_Data_Tree_Node(array(), 'root', new Varien_Data_Tree());
		$this->addData(array(
            'cache_lifetime' => false,
        ));
    }

    /**
     * Get top menu html
     *
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @return string
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '')
    {
        Mage::dispatchEvent('page_block_html_topmenu_gethtml_before', array(
            'menu' => $this->_menu,
            'block' => $this
        ));

        $this->_menu->setOutermostClass($outermostClass);
        $this->_menu->setChildrenWrapClass($childrenWrapClass);

		
        $html = $this->_getHtml($this->_menu, $childrenWrapClass);
		
		
        Mage::dispatchEvent('page_block_html_topmenu_gethtml_after', array(
            'menu' => $this->_menu,
            'html' => $html
        ));

        return $html;
    }

    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Varien_Data_Tree_Node $menuTree
     * @param string $childrenWrapClass
     * @return string
     */
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
		global $magmenu, $click;
       	$html = '';
        $children = $menuTree->getChildren();  
        $count = $children->count();
        $key = 1;
		/*if($click)
		{*/
			$cvalue = 'data-toggle="dropdown"';
		/*}*/
        foreach ($children as $child) {

             $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
                     
             if($child->hasChildren())
             {
              	if($child->getIsActive())
             	{
					if($stretch)
					{
             		$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
					. $this->escapeHtml($child->getName()) . '<hr class="horiz_separator" /></a>';
					
					}
					else
					{
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
					. $this->escapeHtml($child->getName()) . '</a>';
					if ($key != $count)
             		{
             			$html .='<hr class="horiz_separator" />';
             		}
					}
             	}
             	else
             	{
					if($stretch)
					{     
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
						. $this->escapeHtml($child->getName()) . '<hr class="horiz_separator" /></a>';						
					}
					else
					{
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
						. $this->escapeHtml($child->getName()) . '</a>';
						if ($key != $count)
						{
							$html .='<hr class="horiz_separator" />';
						}
					}
             	}
             
            	$childrenlevel1=$child->getChildren();
            	$html .= $this->generate_level1_children($childrenlevel1);
             }  
             else 
             {
             if($child->getIsActive())
             	{
					if($stretch)
					{
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active"><span class="menuchildicon"></span>'
						. $this->escapeHtml($child->getName()) . '<hr class="horiz_separator" /></a>';
					}
					else
					{
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active"><span class="menuchildicon"></span>'
						. $this->escapeHtml($child->getName()) . '</a>';
						if ($key != $count)
						{
             			$html .='<hr class="horiz_separator" />';
						}
					}
             	}
             	else
             	{
					if($stretch)
					{
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link"><span class="menuchildicon"></span>'
						. $this->escapeHtml($child->getName()) . '<hr class="horiz_separator" /></a>';
					}
					else
					{
						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link"><span class="menuchildicon"></span>'
						. $this->escapeHtml($child->getName()) . '</a>';
						if ($key != $count)
						{
             			$html .='<hr class="horiz_separator" />';
						}
					}
				}
             } 
            
            $html .= '</li>';
			$key++;
        }

        return $html;
    }

    public function generate_level1_children($children)
	{
		global $magmenu;
		$count = $children->count();;
        $key = 1;
	
		$output='';
		$output.='<ul class="child dropdown-menu" role="menu">';
		
	/*	if ($magmenu)
			{	
				$output.='<div class="row" />';
			}		*/
		
		foreach($children as $tree_item)
		{
		    if ($magmenu)
					{	
						$output.='<li class="span1 unstyled dropdown dropdown-submenu" >';
					}
					else
					{
						$output.='<li class="dropdown dropdown-submenu">';	
					}
			
				if($tree_item->hasChildren())
				{	
					if($stretch)
					{
						$output.= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '<hr class="separator" /></a>';
					}
					else
					{
						$output.= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
						if ($magmenu || $horzmenu)
						{	
							$output.='<hr class="separator" />';
						}
						else 
						{
							if($key != $count)
							{
								$output.='<hr class="separator" />';
							}
						}	
					}
					
					$childrenlevel2=$tree_item->getChildren();
					
					if ($magmenu)
					{
					/* $output.= '</li>'; */
			 		$output.= $this->generate_level2_children($childrenlevel2);
			 		}
					else
					{
						$output.= $this->generate_level2_children($childrenlevel2);
						/* $output.= '</li>'; */
					}
				
					
				}
				else
				{
				if($stretch)
					{
					$output.='<a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '<hr class="separator" /></a>';
					}
					else
					{
						$output.='<a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
						if ($magmenu || $horzmenu)
						{	
							$output.='<hr class="separator" />';
						}
						else 
						{
							if($key != $count)
							$output.='<hr class="separator" />';
						}
						/* $output.= '</li>'; */
					}
				}
				
				/* if($magmenu)
				{	*/
					$output.='</li >';
				/* } */
				$key++;
		
		}
		/* if ($magmenu)
		{
			$output.='</div>';
		}
		*/
		$output.='</ul>';
		return $output;
	}

	public function generate_level2_children($children)
	{
		global $magmenu;
		global $horzmenu;
		$count = $children->count();;
        $key = 1;
	
		$output='';
		if ($magmenu)
		{
			$output.='<ul role="menu">';
		}
		elseif ($horzmenu)
		{
			$output.='<ul class="sub-menu" role="menu">';
		}
		else
		{
			$output.='<ul id="dropdown-menu" class="dropdown-menu sub-menu" role="menu">';
		}
		foreach($children as $tree_item)
		{
		
			if($tree_item->hasChildren())
			{
			
				if($stretch)
				{
					$output.= '<li class="dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '<hr class="separator" /></a>';
				}
				else
				{
					$output.= '<li class="dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
					if ($magmenu || $horzmenu)
					{	
						$output.='<hr class="separator" />';
					}
					else 
					{
						if($key != $count)
							$output.='<hr class="separator" />';
					}
				}
				
			    $childrenlevel3=$tree_item->getChildren();
  				$output.= $this->generate_level2_children($childrenlevel3);
				$output.= '</li>';
			}
		else{
				if($stretch)
				{
					$output.='<li><a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '<hr class="separator" /></a>';
				}
				else
				{		
					$output.='<li><a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
					if ($magmenu || $horzmenu)
					{	
						$output.='<hr class="separator" />';
					}
					else 
					{
						if($key != $count)
						$output.='<hr class="separator" />';
					}
				}
				$output.= '</li>';
			}
			$key++;
		}
	$output.='</ul>';
	return $output;
	 }     
     /**
     * Generates string with all attributes that should be present in menu item element
     *
     * @param Varien_Data_Tree_Node $item
     * @return string
     */
    protected function _getRenderedMenuItemAttributes(Varien_Data_Tree_Node $item)
    {
        $html = '';
        $attributes = $this->_getMenuItemAttributes($item);

        foreach ($attributes as $attributeName => $attributeValue) {
            $html .= ' ' . $attributeName . '="' . str_replace('"', '\"', $attributeValue) . '"';
        }

        return $html;
    }

    /**
     * Returns array of menu item's attributes
     *
     * @param Varien_Data_Tree_Node $item
     * @return array
     */
    protected function _getMenuItemAttributes(Varien_Data_Tree_Node $item)
    {
        $menuItemClasses = $this->_getMenuItemClasses($item);
        $attributes = array(
            'class' => implode(' ', $menuItemClasses)
        );

        return $attributes;
    }

    /**
     * Returns array of menu item's classes
     *
     * @param Varien_Data_Tree_Node $item
     * @return array
     */
    protected function _getMenuItemClasses(Varien_Data_Tree_Node $item)
    {
        $classes = array();

        $classes[] = 'ttr_menu_items_parent dropdown';
		if ($item->getIsActive()) {
            $classes[] = 'ttr_menu_items_parent dropdown active';
        }
        
        return $classes;
    }
	
	/**
     * Retrieve cache key data
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $shortCacheId = array(
            'TOPMENU',
            Mage::app()->getStore()->getId(),
            Mage::getDesign()->getPackageName(),
            Mage::getDesign()->getTheme('template'),
            Mage::getSingleton('customer/session')->getCustomerGroupId(),
            'template' => $this->getTemplate(),
            'name' => $this->getNameInLayout(),
            $this->getCurrentEntityKey()
        );
        $cacheId = $shortCacheId;

        $shortCacheId = array_values($shortCacheId);
        $shortCacheId = implode('|', $shortCacheId);
        $shortCacheId = md5($shortCacheId);

        $cacheId['entity_key'] = $this->getCurrentEntityKey();
        $cacheId['short_cache_id'] = $shortCacheId;

        return $cacheId;
    }

    /**
     * Retrieve current entity key
     *
     * @return int|string
     */
    public function getCurrentEntityKey()
    {
        if (null === $this->_currentEntityKey) {
            $this->_currentEntityKey = Mage::registry('current_entity_key')
                ? Mage::registry('current_entity_key') : Mage::app()->getStore()->getRootCategoryId();
        }
        return $this->_currentEntityKey;
    }
}