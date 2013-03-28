        		<?php 
					$strFormState = sprintf('<input type="hidden" name="%s" id="%s" value="%s" />', MJaxFormPostData::MJaxForm__FormState, MJaxFormPostData::MJaxForm__FormState, MJaxForm::Serialize($this));
					echo($strFormState);
				?>		
        		</form> 
           	</div>

        	<?php
            	$this->RenderHeaderAssetsAsJs();
				$this->RenderControlJSCalls();
				$this->RenderClassJSCalls();
				$this->RenderControlRegisterJS();
				$this->RenderMiscJSCalls();   
			?> 	
				
        </div>       
    </body>
</html>